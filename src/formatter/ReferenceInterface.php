<?php
namespace gossi\trixionary\client\formatter;

interface ReferenceInterface {
	
	const BOOK = 'book';
	const ARTICLE = 'article';
	const INBOOK = 'inbook';
	const INCOLLECTION = 'incollection';
	const URL = 'url';
	const UNPUBLISHED = 'unpublished';
	const BACHELORTHESIS = 'bachelorthesis';
	const MASTERTHESIS = 'masterthesis';
	const DIPLOMATHESIS = 'diplomathesis';
	const PHDTHESIS = 'phdthesis';
	const HABILITATIONTHESIS = 'habilitationthesis';
	const MULTIMEDIA = 'multimedia';
	
	/**
	 * @return int
	 */
	public function getId();
	
	/**
	 * Returns the type, one of the ReferenceInterface constants
	 * @return string
	 */
	public function getType();
	
	/**
	 * @return string
	 */
	public function getTitle();
	
	/**
	 * @return string
	 */
	public function getBooktitle();
	
	/**
	 * @return int
	 */
	public function getYear();
	
	/**
	 * @return string
	 */
	public function getAuthor();
	
	/**
	 * @return string
	 */
	public function getPublisher();
	
	/**
	 * @return string
	 */
	public function getAddress();
	
	/**
	 * @return string
	 */
	public function getEditor();
	
	/**
	 * @return string
	 */
	public function getJournal();
	
	/**
	 * @return string
	 */
	public function getNumber();
	
	/**
	 * @return string
	 */
	public function getSchool();
	
	/**
	 * @return string
	 */
	public function getVolume();
	
	/**
	 * @return string
	 */
	public function getEdition();
	
	/**
	 * @return string
	 */
	public function getPages();
	
	/**
	 * @return string
	 */
	public function getHowpublished();

	/**
	 * @return string
	 */
	public function getNote();
	
	/**
	 * @return string
	 */
	public function getUrl();
	
	/**
	 * Returns lastchecked
	 * @param string $format
	 * @return string|\DateTime string when $format is passed, anyway a DateTime object
	 */
	public function getLastchecked($format = null);

}