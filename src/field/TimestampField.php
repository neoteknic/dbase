<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace org\majkel\dbase\field;

use \org\majkel\dbase\Field;
use DateTime;

/**
 * Description of Field
 *
 * @author majkel
 */
class TimestampField extends Field {

    /**
     * CharacterField constructor.
     */
    public function __construct() {
        $this->length = 8;
    }

    /**
     * {@inheritdoc}
     */
    public function toData($value) {
        if ($value === null) {
            return '';
        }

	    if ($value instanceof DateTime) {
	        return $value->format('YmdHis');
	    }
	    
	    if (is_string($value)) {
	        return date('YmdHis', strtotime($value));
	    }
	    
	    return date('YmdHis', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function fromData($data) {
        $date = new DateTime();
        if (preg_match('/^[0-9]+$/', $data)) {
            $date->setDate(
                (int)substr($data, 0, 4),
                (int)substr($data, 4, 2),
                (int)substr($data, 6, 2)
            );
            $date->setTime(
            	(int)substr($data, 8, 2),
	            (int)substr($data, 10, 2),
	            (int)substr($data, 12, 2)
            );
        } else {
            $date->setTimestamp(0);
        }
        return $date;
    }

    /**
     * {@inheritdoc}
     */
    public function getType() {
        return Field::TYPE_TIMESTAMP;
    }

}
