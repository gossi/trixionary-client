<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\Skill;
use gossi\trixionary\model\Map\SkillTableMap;
use gossi\trixionary\client\formatter\apa\ApaFormatter;
use gossi\trixionary\model\Kstruktur;
use gossi\trixionary\model\FunctionPhase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Displays a skill
 * 
 * @author gossi
 */
class SkillAction extends AbstractSkillAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$skill = $this->getSkill();
		$this->getServiceContainer()->getApplication()->getPage()->setTitle($skill->getName());
		
		// references
		$formatter = new ApaFormatter();
		$references = [];
		foreach ($skill->getReferences() as $reference) {
			$references[] = $reference;
		}
		$references = $formatter->sort($references);
		
		// videos
		$videos = [];
		$tutorials = [];
		foreach ($skill->getVideos() as $video) {
			if ($video->getIsTutorial()) {
				$tutorials[] = $video;
			} else {
				$videos[] = $video;
			}
		}
		
		
		// kstruktur
		$kstrukturNodes = [];
		$kstrukturEdges = [];
		$kstrukturRoot = null;
		foreach ($skill->getKstrukturs() as $kstruktur) {
			$kstrukturNodes[] = [
				'id' => $kstruktur->getId(),
				'group' => $kstruktur->getType(),
				'label' => $kstruktur->getTitle(),
				'parent' => $kstruktur->getParentId()
			];
			
			if ($kstruktur->getParent()) {
				$kstrukturEdges[] = [
					'id' => $kstruktur->getId() . '-' . $kstruktur->getParentId(),
					'from' => $kstruktur->getId(),
					'to' => $kstruktur->getParentId()
				];
			} else {
				$kstrukturRoot = $kstruktur->getId();
			}
		}
		
		// function phase
		$functionPhaseNodes = [];
		$functionPhaseEdges = [];
		$functionPhaseRoot = null;
		foreach ($skill->getFunctionPhases() as $functionPhase) {
			$functionPhaseNodes[] = [
				'id' => $functionPhase->getId(),
				'group' => $functionPhase->getType(),
				'label' => $functionPhase->getTitle(),
				'parent' => $functionPhase->getParentId()
			];
	
			if ($functionPhase->getParent()) {
				$functionPhaseEdges[] = [
					'id' => $functionPhase->getId() . '-' . $functionPhase->getParentId(),
					'from' => $functionPhase->getId(),
					'to' => $functionPhase->getParentId()
				];
			} else {
				$functionPhaseRoot = $functionPhase->getId();
			}
		}
		
		$fs = new Filesystem();
		$this->addData([
			'skill' => $skill,
			'sequence_url' => $fs->exists($this->getTrixionary()->getSequencePath($skill)) 
				? $this->getTrixionary()->getSequenceUrl($skill)
				: '', 
			'videos' => $videos,
			'tutorials' => $tutorials,
			'formatter' => $formatter,
			'references' => $references,
			'functionphase_root' => $functionPhaseRoot,
			'functionphase_default_type' => FunctionPhase::HELPFUL,
			'functionphase_nodes' => json_encode($functionPhaseNodes),
			'functionphase_edges' => json_encode($functionPhaseEdges),
			'functionphase_types' => [FunctionPhase::MAIN, FunctionPhase::HELPFUL, FunctionPhase::PREPARE, FunctionPhase::SUPPORT, FunctionPhase::TRANSITION],
			'functionphase_update_url' => $this->generateUrl('functionphase-update', ['skill' => $skill->getSlug()]),
			'kstruktur_root' => $kstrukturRoot,
			'kstruktur_default_type' => Kstruktur::STRUCTURE,
			'kstruktur_nodes' => json_encode($kstrukturNodes),
			'kstruktur_edges' => json_encode($kstrukturEdges),
			'kstruktur_types' => [Kstruktur::STRUCTURE, Kstruktur::EFFECT, Kstruktur::ACTION],
			'kstruktur_update_url' => $this->generateUrl('kstruktur-update', ['skill' => $skill->getSlug()]),
			'url_pattern' => $this->generateUrl('skill', ['skill' => '_skill_']),
			'group_url_pattern' => $this->generateUrl('group', ['group' => '_group_']),
			'transitions_in_url' => $this->generateUrl('transitions', ['from' => $skill->getStartPosition()->getSlug()]),
			'transitions_in_count' => SkillQuery::create()->filterByEndPosition($skill->getStartPosition())->where(SkillTableMap::COL_START_POSITION_ID . ' != ' . SkillTableMap::COL_END_POSITION_ID)->count(),
			'transitions_out_url' => $this->generateUrl('transitions', ['to' => $skill->getEndPosition()->getSlug()]),
			'transitions_out_count' => SkillQuery::create()->filterByStartPosition($skill->getEndPosition())->where(SkillTableMap::COL_START_POSITION_ID . ' != ' . SkillTableMap::COL_END_POSITION_ID)->count(),
			'flags' => [
				'movender' => Skill::FLAG_MOVENDER,
				'movendum' => Skill::FLAG_MOVENDUM,
				'simultaneous' => Skill::FLAG_SIMULTANEOUS,
				'isolated' => Skill::FLAG_ISOLATED,
				'same' => Skill::FLAG_SAME,
				'opposite' => Skill::FLAG_OPPOSITE
			]
		]);
		return $this->getResponse($request);
	}

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
