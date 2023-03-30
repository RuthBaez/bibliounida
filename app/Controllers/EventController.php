<?php

use App\Core\baseController;
use App\Core\helpers;
use App\Models\Api\Response;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Organizer;
use App\Models\User;
use App\Utils\Audit\InterfaceAudit;
use App\Utils\Authentication\InterfaceAuthentication;

class EventController extends baseController
{
    protected $authentication;
    protected $pdf;
    protected $audit;
    protected $helpers;

    public function __construct(InterfaceAuthentication $authentication, InterfaceAudit $audit)
    {
        $this->authentication = $authentication;
        $this->audit = $audit;

        $this->helpers = new helpers();
    }

    public function Index()
    {
        $this->authentication($this->authentication->isAuth());

        $event_model = new Event();
        $events = $event_model->getAll();

        $user_model = new User();

        foreach($events as $event) {
            $event->organizer_event = $user_model->getByOne('id', $event->organizer_event);
        }

        $this->view('Events/Inicio', [
            'title' => 'Eventos',
            'events' => $events
        ], true);
    }

    public function getEventsPendients()
    {
        $event_model = new Event();
        $events = $event_model->getAll();

        $events_pendientes = [];
        foreach($events as $event) {
            if ((int) $event->state_event === 2)
                array_push($events_pendientes, $event);
        }

        $response = new Response(true, null, $events_pendientes);

        return $this->json($response);
    }

    public function Register()
    {
        $this->authentication($this->authentication->isAuth());

        $organizer_model = new Organizer();
        $organizers = $organizer_model->getAll();

        $user_model = new User();

        $user = $this->helpers->getSession();

        if (count($organizers) === 0) {
            $organizer = new Organizer([
                'id' => null,
                'id_user' => $user->id,
                'is_actived' => 1
            ]);

            if ($organizer->save()) {
                $organizers = $organizer_model->getAll();
            }
        }

        foreach($organizers as $organizer) {
            $organizer->id_user = $user_model->getByOne('id', $organizer->id_user);
        }

        $this->view('Events/Register', [
            'title' => 'Crear evento',
            'organizers' => $organizers
        ], true);
    }

    public function Detalle()
    {
        $this->authentication($this->authentication->isAuth());

        if ( !isset($_GET['id']) ) {
            $this->redirect('event', 'index', 'danger', 'El evento ingresado no fue encontrado');
            return;
        }

        $id_event = $_GET['id'];

        $event_model = new Event();
        $event = $event_model->getByOne('id_event', $id_event);

        $user_model = new User();
        $event->organizer_event = $user_model->getByOne('id', $event->organizer_event);

        $event_participant_model = new EventParticipant();
        $participants = $event_participant_model->getBy('id_event', $id_event);

        $this->view('Events/Detalle', [
            'title' => 'Informacion',
            'event' => $event,
            'participants' => $participants
        ], true);
    }

    public function Add()
    {
        $this->authentication($this->authentication->isAuth());

        if (
            !isset($_POST['event_name']) &&
            !isset($_POST['organizer']) &&
            !isset($_POST['event_type']) &&
            !isset($_POST['aforo']) &&
            !isset($_POST['event_date']) &&
            !isset($_POST['event_time']) &&
            !isset($_POST['event_point']) &&
            !isset($_POST['event_detail'])
        ) {
            return $this->redirect('event', 'register', 'danger', 'Los datos requeridos no fueron enviados');
        }

        if (
            empty($_POST['event_name']) &&
            empty($_POST['organizer']) &&
            empty($_POST['event_type']) &&
            empty($_POST['event_date']) &&
            empty($_POST['event_time']) &&
            empty($_POST['event_point']) &&
            empty($_POST['event_detail'])
        ) {
            return $this->redirect('event', 'register', 'danger', 'Los datos requeridos no fueron enviados');
        }

        $event_name = $_POST['event_name'];
        $organizer = $_POST['organizer'];
        $event_type = $_POST['event_type'];
        $aforo = $_POST['aforo'];
        $event_date = $_POST['event_date'];
        $event_time = $_POST['event_time'];
        $event_point = $_POST['event_point'];
        $event_detail = $_POST['event_detail'];

        if ($event_type === 'Limitado' && $aforo <= 0) {
            return $this->redirect('event', 'register', 'danger', 'El numero de aforo no fue asignado');
        }

        $new_event = [
            'id_event' => null,
            'title_event' => $event_name,
            'info_event' => $event_detail,
            'organizer_event' => $organizer,
            'date_realized_event' => $event_date,
            'time' => $event_time,
            'date_created_event' => date('Y-m-d'),
            'place_event' => $event_point,
            'type_event' => $event_type,
            'participants_event' => $aforo <= 0 ? null : $aforo,
            'state_event' => 2
        ];

        $event_model = new Event($new_event);

        if ( !$event_model->save() ) {
            return $this->redirect('event', 'register', 'danger', "Ocurrio un error al guardar el evento");
        }

        $id_event = $event_model->lastInsertId();

        $user = $this->helpers->getSession();

        $this->audit->create('Eventos', 'Creacion de nuevo Evento ' . $id_event, $user->id, $this->helpers->getCurrentDateTime());

        $this->redirect('event', 'detalle', 'success', 'El evento ha sido registrado satisfactoriamente', [ 'id' => $id_event ]);
    }

    public function EditEvent()
    {
        $this->authentication($this->authentication->isAuth());

        if ( !isset($_GET['id']) ) {
            $this->redirect('event', 'index', 'danger', 'El Evento ingresado no fue encontrado');
            return;
        }

        $id_event = $_GET['id'];

        $event_model = new Event();
        $event = $event_model->getByOne('id_event', $id_event);

        $organizer_model = new Organizer();
        $organizers = $organizer_model->getAll();

        $user_model = new User();

        foreach($organizers as $organizer) {
            $organizer->id_user = $user_model->getByOne('id', $organizer->id_user);
        }

        $organizers = array_filter($organizers, fn($organizer) => (int) $organizer->id_user->id !== (int) $event->organizer_event);

        $organizer = $organizer_model->getByOne('id_user', $event->organizer_event);
        $organizer->id_user = $user_model->getByOne('id', $organizer->id_user);

        array_unshift($organizers, $organizer);

        $this->view('Events/EditEvent', [
            'title' => 'Editar Evento',
            'event' => $event,
            'organizers' => $organizers
        ], true);
    }

    public function Edit()
    {
        $this->authentication($this->authentication->isAuth());

        if ( !isset($_GET['id']) ) {
            $this->redirect('event', 'index', 'danger', 'El evento ingresado no fue encontrado');
            return;
        }

        $id_event = $_GET['id'];

        if (
            !isset($_POST['event_name']) &&
            !isset($_POST['organizer']) &&
            !isset($_POST['event_type']) &&
            !isset($_POST['aforo']) &&
            !isset($_POST['event_date']) &&
            !isset($_POST['event_time']) &&
            !isset($_POST['event_point']) &&
            !isset($_POST['event_detail']) &&
            !isset($_POST['state_event'])
        ) {
            return $this->redirect('event', 'editevent', 'danger', 'Los datos requeridos no fueron enviados', [ 'id' => $id_event ]);
        }

        if (
            empty($_POST['event_name']) &&
            empty($_POST['organizer']) &&
            empty($_POST['event_type']) &&
            empty($_POST['event_date']) &&
            empty($_POST['event_time']) &&
            empty($_POST['event_point']) &&
            empty($_POST['event_detail'])
        ) {
            return $this->redirect('event', 'editevent', 'danger', 'Los datos requeridos no fueron enviados', [ 'id' => $id_event ]);
        }

        $event_name = $_POST['event_name'];
        $organizer = $_POST['organizer'];
        $event_type = $_POST['event_type'];
        $aforo = $_POST['aforo'];
        $event_date = $_POST['event_date'];
        $event_time = $_POST['event_time'];
        $event_point = $_POST['event_point'];
        $event_detail = $_POST['event_detail'];
        $state_event = (int) $_POST['state_event'];

        if ($event_type === 'Limitado' && $aforo <= 0) {
            return $this->redirect('event', 'editevent', 'danger', 'El numero de aforo no fue asignado', [ 'id' => $id_event ]);
        }

        $current_date = $this->helpers->getCurrentDateTime();

        if ($state_event === 1 && $current_date < $this->helpers->getCustomDate($event_date, 'Y-m-d')) {
            return $this->redirect('event', 'editevent', 'danger', 'El evento no puede cambiar como realizado', [ 'id' => $id_event ]);
        }

        $edit_event = [
            'id_event' => $id_event,
            'title_event' => $event_name,
            'info_event' => $event_detail,
            'organizer_event' => $organizer,
            'date_realized_event' => $event_date,
            'time' => $event_time,
            'date_created_event' => date('Y-m-d'),
            'place_event' => $event_point,
            'type_event' => $event_type,
            'participants_event' => $aforo <= 0 ? null : $aforo,
            'state_event' => $state_event
        ];

        $event_model = new Event($edit_event);

        if ( !$event_model->update() ) {
            return $this->redirect('event', 'eventedit', 'danger', "Ocurrio un error al guardar el evento", [ 'id' => $id_event ]);
        }

        $user = $this->helpers->getSession();

        $this->audit->create('Eventos', 'Evento Actualizado ' . $id_event, $user->id, $this->helpers->getCurrentDateTime());

        $this->redirect('event', 'detalle', 'success', 'El evento ha sido actualizado satisfactoriamente', [ 'id' => $id_event ]);
    }
}
