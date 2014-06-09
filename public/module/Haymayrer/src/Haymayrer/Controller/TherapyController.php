<?php

namespace Haymayrer\Controller;

use Haymayrer\Constant\DBData;
use Haymayrer\Entity\Attendance;
use Haymayrer\Entity\AttendanceExtended;
use Haymayrer\Entity\Participation;
use Haymayrer\Form\TherapyEdit as TherapyEditForm;
use Haymayrer\Form\TherapyAdd as TherapyAddForm;
use Haymayrer\Mapper\Child;
use Haymayrer\Mapper\Attendance as AttendanceMapper;
use Haymayrer\Mapper\Participation as ParticipationMapper;
use Haymayrer\Mapper\Child as ChildMapper;
use Zend\Debug\Debug;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class TherapyController extends AbstractActionController {
    public function indexAction() {
	    /**
	     * @var AttendanceMapper $mapper
	     */
	    $mapper = $this->getServiceLocator()->get('AttendanceMapper');
	    $result = $mapper->fetchAll([
		    'status' => 'active',
	    ]);

	    return new ViewModel([
		    'data' => $result,
	    ]);
    }

	public function addAction() {
		/**
		 * @var Request $request
		 */
		$request = $this->getRequest();

		$therapyForm = new TherapyAddForm($this->getServiceLocator(), $this->url()->fromRoute('therapy-add'));
		$therapyForm->prepare();

		if ($request->isPost()) {
			$therapyForm->setData($request->getPost());

			if ($therapyForm->isValid()) {
				/**
				 * @var AttendanceMapper $attendanceMapper
				 * @var ParticipationMapper $participationMapper
				 */
				$attendanceMapper = $this->getServiceLocator()->get('AttendanceMapper');
				$participationMapper = $this->getServiceLocator()->get('ParticipationMapper');

				$attendanceEntity = new Attendance();
				$attendanceEntity->setTherapyId($request->getPost('therapy_id'));
				$attendanceEntity->setDateFrom($request->getPost('date_from'));
				$attendanceEntity->setDateTo($request->getPost('date_to'));
				$attendanceEntity->setDescription($request->getPost('description'));
				$attendanceEntity->setTimestamp(date('Y-m-d H:i:s'));

				$attendanceMapper->insert($attendanceEntity);
				$attendanceId = $attendanceMapper->lastInsertValue;

				if (count($request->getPost('participants'))) {
					foreach ($request->getPost('participants') as $childId) {
						$participationEntity = new Participation();
						$participationEntity->setAttendanceId($attendanceId);
						$participationEntity->setChildId($childId);

						$participationMapper->insert($participationEntity);
					}
				} else {
					throw new \Exception('No participants selected.');
				}

				$this->redirect()->toRoute('therapy');
			} else {
				$therapyForm->populateValues($request->getPost());
			}
		}

		return new ViewModel([
			'form' => $therapyForm,
			'children' => $this->getChildrenList(),
		]);
	}

	public function viewAction() {
		$attendanceId = $this->params()->fromRoute('id', 0);

		/**
		 * @var ParticipationMapper $mapper
		 * @var ChildMapper $childMapper
		 */
		$mapper = $this->getServiceLocator()->get('ParticipationMapper');
		$childMapper = $this->getServiceLocator()->get('ChildMapper');
		$result = $mapper->fetchExtendedAttendanceList($attendanceId);
		$participationData = $this->reformatExtendedAttendanceResult($result);

		return new ViewModel([
			'data' => $participationData,
			'urlEditTherapy' => $this->url()->fromRoute('therapy-edit', [
				'id' => $attendanceId,
			]),
			'urlDeleteTherapy' => $this->url()->fromRoute('therapy-delete', [
				'id' => $attendanceId,
			]),
			'urlAddParticipant' => $this->url()->fromRoute('therapy-add-participant', [
				'id' => $attendanceId,
				'child_id' => 'replacement'
			]),
			'children' => $childMapper->fetchExtendedChildListWithExceptions(
				$this->reformatParticipants($participationData['participants'])
			),
		]);
	}

	public function deleteAction() {
		/**
		 * @var AttendanceMapper $attendanceMapper
		 * @var ParticipationMapper $participationMapper
		 */
		$attendanceId = $this->params()->fromRoute('id', 0);

		$attendanceMapper = $this->getServiceLocator()->get('AttendanceMapper');
		$participationMapper = $this->getServiceLocator()->get('ParticipationMapper');

		$participationMapper->delete([
			'attendance_id' => $attendanceId,
		]);

		$attendanceMapper->delete([
			'id' => $attendanceId,
		]);

		$this->redirect()->toRoute('therapy');
	}

	public function editAction() {
		/**
		 * @var Request $request
		 * @var AttendanceMapper $mapper
		 */
		$request = $this->getRequest();
		$id = $this->params()->fromRoute('id');

		$attendanceForm = new TherapyEditForm($this->getServiceLocator(), $this->url()->fromRoute('therapy-edit', [
			'id' => $this->params()->fromRoute('id'),
		]));
		$attendanceForm->prepare();

		if ($request->isPost()) {
			$attendanceForm->setData($request->getPost());

			if ($attendanceForm->isValid()) {
				$attendanceEntity = new Attendance();
				$attendanceEntity->setTherapyId($request->getPost('therapy_id'));
				$attendanceEntity->setDateFrom($request->getPost('date_from'));
				$attendanceEntity->setDateTo($request->getPost('date_to'));
				$attendanceEntity->setDescription($request->getPost('description'));

				$mapper = $this->getServiceLocator()->get('AttendanceMapper');
				$mapper->update($attendanceEntity, ['id' => $id]);

				$this->redirect()->toRoute('therapy-view', [
					'id' => $id,
				]);
			} else {
				$attendanceForm->populateValues($request->getPost());
			}
		} else {
			$mapper = $this->getServiceLocator()->get('AttendanceMapper');
			$result = $mapper->fetchOne([
				'id' => $id,
			]);

			$attendanceForm->populateValues($result->exchangeArray());
		}

		return new ViewModel([
			'form' => $attendanceForm,
		]);
	}

	public function statusAction() {
		$output = [
			'status' => 'success',
			'message' => 'Status successfully changed',
		];

		try {
			$authService = $this->getServiceLocator()->get('auth');

			if (!$authService->hasIdentity()) {
				throw new \Exception('Not authentified user detected.');
			}

			$id = $this->params()->fromRoute('id', 0);
			$status = $this->params()->fromRoute('status', 'complete');

			/**
			 * @var ParticipationMapper $participationMapper
			 */
			$participationMapper = $this->getServiceLocator()->get('ParticipationMapper');

			$participationEntity = new Participation();
			$participationEntity->setStatus($status);

			if ($participationMapper->update($participationEntity, [
				'id' => $id,
			])) {
				$class = 'text-success';

				switch ($status) {
					case 'partly':
						$class = 'text-warning';
						break;
					case 'never':
						$class = 'text-danger';
						break;
				}

				$output['data'] = [
					'id' => $id,
					'class' => $class,
				];
			} else {
				throw new \Exception('No changes have been made.');
			}
		} catch(\Exception $ex) {
			$output = [
				'status' => 'error',
				'message' => $ex->getMessage(),
			];
		}

		return new JsonModel($output);
	}

	public function addParticipantAction() {
		/**
		 * @var Request $request
		 * @var ParticipationMapper $participationMapper
		 */
		$attendanceId = $this->params()->fromRoute('id', 0);
		$newChildId = $this->params()->fromRoute('child_id', 0);

		if ($attendanceId && $newChildId) {
			$participationMapper = $this->getServiceLocator()->get('ParticipationMapper');

			$participationEntity = new Participation();
			$participationEntity->setAttendanceId($attendanceId);
			$participationEntity->setChildId($newChildId);

			$participationMapper->insert($participationEntity);
		}

		$this->redirect()->toRoute('therapy-view', [
			'id' => $attendanceId,
		]);
	}

	public function deleteParticipantAction() {
		/**
		 * @var Request $request
		 * @var ParticipationMapper $participationMapper
		 */
		$attendanceId = $this->params()->fromRoute('id', 0);
		$newChildId = $this->params()->fromRoute('child_id', 0);

		if ($attendanceId && $newChildId) {
			$participationMapper = $this->getServiceLocator()->get('ParticipationMapper');
			$participationMapper->delete([
				'child_id' => $newChildId
			]);
		}

		$this->redirect()->toRoute('therapy-view', [
			'id' => $attendanceId,
		]);
	}

	private function getChildrenList() {
		/** @var Child $mapper */
		$mapper = $this->getServiceLocator()->get('ChildMapper');
		$result = $mapper->fetchExtendedChildList();
		$output = [];

		if ($result->count()) {
			$counter = 1;

			foreach ($result as $child) {
				$tags = [];

				!$child->getSingleMother() ?: array_push($tags, 'Single Mother');
				!$child->getInNeed() ?: array_push($tags, 'In Need');

				$output[] = [
					'id' => $child->getId(),
					'name' => $child->getName(),
					'disease' => DBData::getDisease($child->getDisease()),
					'attendance' => $child->getAttendanceCount(),
					'tags' => $tags,
					'sort' => $counter++
				];
			}
		} else {
			throw new \Exception('No child found.');
		}

		return $output;
	}

	/**
	 * @param AttendanceExtended[]|\ArrayObject|null $result
	 * @return array|bool
	 * @throws \Exception
	 */
	private function reformatExtendedAttendanceResult($result) {
		if ($result->count()) {
			$attendance = [];
			$participants = [];

			foreach ($result as $participant) {
				if (!count($attendance)) {
					$attendance = [
						'therapy' => DBData::getTherapy($participant->getAttendanceTherapyId()),
						'date_from' => $participant->getAttendanceDateFrom(),
						'date_to' => $participant->getAttendanceDateTo(),
						'description' => $participant->getAttendanceDescription(),
						'timestamp' => $participant->getAttendanceTimestamp(),
					];
				}

				$participants[] = [
					'id' => $participant->getChildId(),
					'participation_id' => $participant->getParticipationId(),
					'name' => $participant->getChildName(),
					'status' => $participant->getChildParticipationStatus(),
					'single_mother' => $participant->getParentSingleMother(),
					'in_need' => $participant->getParentInNeed(),
					'delete_url' => $this->url()->fromRoute('therapy-delete-participant', [
						'id' => $participant->getAttendanceId(),
						'child_id' => $participant->getChildId(),
					])
				];
			}
		} else {
			return false;
		}

		return [
			'attendance' => $attendance,
			'participants' => $participants,
		];
	}

	private function reformatParticipants(array $participants) {
		$output = [];

		if (count($participants)) {
			foreach ($participants as $child) {
				array_push($output, $child['id']);
			}
		}

		return $output;
	}
}
