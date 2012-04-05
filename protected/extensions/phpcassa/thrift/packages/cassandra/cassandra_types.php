<?php
/**
 * Autogenerated by Thrift
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 */
include_once $GLOBALS['THRIFT_ROOT'].'/Thrift.php';


$GLOBALS['cassandra_E_ConsistencyLevel'] = array(
  'ONE' => 1,
  'QUORUM' => 2,
  'LOCAL_QUORUM' => 3,
  'EACH_QUORUM' => 4,
  'ALL' => 5,
  'ANY' => 6,
  'TWO' => 7,
  'THREE' => 8,
);

final class cassandra_ConsistencyLevel {
  const ONE = 1;
  const QUORUM = 2;
  const LOCAL_QUORUM = 3;
  const EACH_QUORUM = 4;
  const ALL = 5;
  const ANY = 6;
  const TWO = 7;
  const THREE = 8;
  static public $__names = array(
    1 => 'ONE',
    2 => 'QUORUM',
    3 => 'LOCAL_QUORUM',
    4 => 'EACH_QUORUM',
    5 => 'ALL',
    6 => 'ANY',
    7 => 'TWO',
    8 => 'THREE',
  );
}

$GLOBALS['cassandra_E_IndexOperator'] = array(
  'EQ' => 0,
  'GTE' => 1,
  'GT' => 2,
  'LTE' => 3,
  'LT' => 4,
);

final class cassandra_IndexOperator {
  const EQ = 0;
  const GTE = 1;
  const GT = 2;
  const LTE = 3;
  const LT = 4;
  static public $__names = array(
    0 => 'EQ',
    1 => 'GTE',
    2 => 'GT',
    3 => 'LTE',
    4 => 'LT',
  );
}

$GLOBALS['cassandra_E_IndexType'] = array(
  'KEYS' => 0,
);

final class cassandra_IndexType {
  const KEYS = 0;
  static public $__names = array(
    0 => 'KEYS',
  );
}

$GLOBALS['cassandra_E_Compression'] = array(
  'GZIP' => 1,
  'NONE' => 2,
);

final class cassandra_Compression {
  const GZIP = 1;
  const NONE = 2;
  static public $__names = array(
    1 => 'GZIP',
    2 => 'NONE',
  );
}

$GLOBALS['cassandra_E_CqlResultType'] = array(
  'ROWS' => 1,
  'VOID' => 2,
  'INT' => 3,
);

final class cassandra_CqlResultType {
  const ROWS = 1;
  const VOID = 2;
  const INT = 3;
  static public $__names = array(
    1 => 'ROWS',
    2 => 'VOID',
    3 => 'INT',
  );
}

class cassandra_Column extends TBase {
  static $_TSPEC;

  public $name = null;
  public $value = null;
  public $timestamp = null;
  public $ttl = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'name',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'value',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'timestamp',
          'type' => TType::I64,
          ),
        4 => array(
          'var' => 'ttl',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'Column';
  }

  public function read($input)
  {
    return $this->_read('Column', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('Column', self::$_TSPEC, $output);
  }
}

class cassandra_SuperColumn extends TBase {
  static $_TSPEC;

  public $name = null;
  public $columns = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'name',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'columns',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => 'cassandra_Column',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'SuperColumn';
  }

  public function read($input)
  {
    return $this->_read('SuperColumn', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('SuperColumn', self::$_TSPEC, $output);
  }
}

class cassandra_CounterColumn extends TBase {
  static $_TSPEC;

  public $name = null;
  public $value = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'name',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'value',
          'type' => TType::I64,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CounterColumn';
  }

  public function read($input)
  {
    return $this->_read('CounterColumn', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CounterColumn', self::$_TSPEC, $output);
  }
}

class cassandra_CounterSuperColumn extends TBase {
  static $_TSPEC;

  public $name = null;
  public $columns = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'name',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'columns',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => 'cassandra_CounterColumn',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CounterSuperColumn';
  }

  public function read($input)
  {
    return $this->_read('CounterSuperColumn', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CounterSuperColumn', self::$_TSPEC, $output);
  }
}

class cassandra_ColumnOrSuperColumn extends TBase {
  static $_TSPEC;

  public $column = null;
  public $super_column = null;
  public $counter_column = null;
  public $counter_super_column = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'column',
          'type' => TType::STRUCT,
          'class' => 'cassandra_Column',
          ),
        2 => array(
          'var' => 'super_column',
          'type' => TType::STRUCT,
          'class' => 'cassandra_SuperColumn',
          ),
        3 => array(
          'var' => 'counter_column',
          'type' => TType::STRUCT,
          'class' => 'cassandra_CounterColumn',
          ),
        4 => array(
          'var' => 'counter_super_column',
          'type' => TType::STRUCT,
          'class' => 'cassandra_CounterSuperColumn',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'ColumnOrSuperColumn';
  }

  public function read($input)
  {
    return $this->_read('ColumnOrSuperColumn', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('ColumnOrSuperColumn', self::$_TSPEC, $output);
  }
}

class cassandra_NotFoundException extends TException {
  static $_TSPEC;


  public function __construct() {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        );
    }
  }

  public function getName() {
    return 'NotFoundException';
  }

  public function read($input)
  {
    return $this->_read('NotFoundException', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('NotFoundException', self::$_TSPEC, $output);
  }
}

class cassandra_InvalidRequestException extends TException {
  static $_TSPEC;

  public $message = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'message',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'InvalidRequestException';
  }

  public function read($input)
  {
    return $this->_read('InvalidRequestException', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('InvalidRequestException', self::$_TSPEC, $output);
  }
}

class cassandra_UnavailableException extends TException {
  static $_TSPEC;


  public function __construct() {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        );
    }
  }

  public function getName() {
    return 'UnavailableException';
  }

  public function read($input)
  {
    return $this->_read('UnavailableException', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('UnavailableException', self::$_TSPEC, $output);
  }
}

class cassandra_TimedOutException extends TException {
  static $_TSPEC;


  public function __construct() {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        );
    }
  }

  public function getName() {
    return 'TimedOutException';
  }

  public function read($input)
  {
    return $this->_read('TimedOutException', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('TimedOutException', self::$_TSPEC, $output);
  }
}

class cassandra_AuthenticationException extends TException {
  static $_TSPEC;

  public $message = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'message',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'AuthenticationException';
  }

  public function read($input)
  {
    return $this->_read('AuthenticationException', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('AuthenticationException', self::$_TSPEC, $output);
  }
}

class cassandra_AuthorizationException extends TException {
  static $_TSPEC;

  public $message = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'message',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'AuthorizationException';
  }

  public function read($input)
  {
    return $this->_read('AuthorizationException', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('AuthorizationException', self::$_TSPEC, $output);
  }
}

class cassandra_SchemaDisagreementException extends TException {
  static $_TSPEC;


  public function __construct() {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        );
    }
  }

  public function getName() {
    return 'SchemaDisagreementException';
  }

  public function read($input)
  {
    return $this->_read('SchemaDisagreementException', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('SchemaDisagreementException', self::$_TSPEC, $output);
  }
}

class cassandra_ColumnParent extends TBase {
  static $_TSPEC;

  public $column_family = null;
  public $super_column = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        3 => array(
          'var' => 'column_family',
          'type' => TType::STRING,
          ),
        4 => array(
          'var' => 'super_column',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'ColumnParent';
  }

  public function read($input)
  {
    return $this->_read('ColumnParent', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('ColumnParent', self::$_TSPEC, $output);
  }
}

class cassandra_ColumnPath extends TBase {
  static $_TSPEC;

  public $column_family = null;
  public $super_column = null;
  public $column = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        3 => array(
          'var' => 'column_family',
          'type' => TType::STRING,
          ),
        4 => array(
          'var' => 'super_column',
          'type' => TType::STRING,
          ),
        5 => array(
          'var' => 'column',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'ColumnPath';
  }

  public function read($input)
  {
    return $this->_read('ColumnPath', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('ColumnPath', self::$_TSPEC, $output);
  }
}

class cassandra_SliceRange extends TBase {
  static $_TSPEC;

  public $start = null;
  public $finish = null;
  public $reversed = false;
  public $count = 100;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'start',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'finish',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'reversed',
          'type' => TType::BOOL,
          ),
        4 => array(
          'var' => 'count',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'SliceRange';
  }

  public function read($input)
  {
    return $this->_read('SliceRange', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('SliceRange', self::$_TSPEC, $output);
  }
}

class cassandra_SlicePredicate extends TBase {
  static $_TSPEC;

  public $column_names = null;
  public $slice_range = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'column_names',
          'type' => TType::LST,
          'etype' => TType::STRING,
          'elem' => array(
            'type' => TType::STRING,
            ),
          ),
        2 => array(
          'var' => 'slice_range',
          'type' => TType::STRUCT,
          'class' => 'cassandra_SliceRange',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'SlicePredicate';
  }

  public function read($input)
  {
    return $this->_read('SlicePredicate', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('SlicePredicate', self::$_TSPEC, $output);
  }
}

class cassandra_IndexExpression extends TBase {
  static $_TSPEC;

  public $column_name = null;
  public $op = null;
  public $value = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'column_name',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'op',
          'type' => TType::I32,
          ),
        3 => array(
          'var' => 'value',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'IndexExpression';
  }

  public function read($input)
  {
    return $this->_read('IndexExpression', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('IndexExpression', self::$_TSPEC, $output);
  }
}

class cassandra_IndexClause extends TBase {
  static $_TSPEC;

  public $expressions = null;
  public $start_key = null;
  public $count = 100;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'expressions',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => 'cassandra_IndexExpression',
            ),
          ),
        2 => array(
          'var' => 'start_key',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'count',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'IndexClause';
  }

  public function read($input)
  {
    return $this->_read('IndexClause', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('IndexClause', self::$_TSPEC, $output);
  }
}

class cassandra_KeyRange extends TBase {
  static $_TSPEC;

  public $start_key = null;
  public $end_key = null;
  public $start_token = null;
  public $end_token = null;
  public $count = 100;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'start_key',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'end_key',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'start_token',
          'type' => TType::STRING,
          ),
        4 => array(
          'var' => 'end_token',
          'type' => TType::STRING,
          ),
        5 => array(
          'var' => 'count',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'KeyRange';
  }

  public function read($input)
  {
    return $this->_read('KeyRange', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('KeyRange', self::$_TSPEC, $output);
  }
}

class cassandra_KeySlice extends TBase {
  static $_TSPEC;

  public $key = null;
  public $columns = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'key',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'columns',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => 'cassandra_ColumnOrSuperColumn',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'KeySlice';
  }

  public function read($input)
  {
    return $this->_read('KeySlice', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('KeySlice', self::$_TSPEC, $output);
  }
}

class cassandra_KeyCount extends TBase {
  static $_TSPEC;

  public $key = null;
  public $count = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'key',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'count',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'KeyCount';
  }

  public function read($input)
  {
    return $this->_read('KeyCount', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('KeyCount', self::$_TSPEC, $output);
  }
}

class cassandra_Deletion extends TBase {
  static $_TSPEC;

  public $timestamp = null;
  public $super_column = null;
  public $predicate = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'timestamp',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'super_column',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'predicate',
          'type' => TType::STRUCT,
          'class' => 'cassandra_SlicePredicate',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'Deletion';
  }

  public function read($input)
  {
    return $this->_read('Deletion', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('Deletion', self::$_TSPEC, $output);
  }
}

class cassandra_Mutation extends TBase {
  static $_TSPEC;

  public $column_or_supercolumn = null;
  public $deletion = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'column_or_supercolumn',
          'type' => TType::STRUCT,
          'class' => 'cassandra_ColumnOrSuperColumn',
          ),
        2 => array(
          'var' => 'deletion',
          'type' => TType::STRUCT,
          'class' => 'cassandra_Deletion',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'Mutation';
  }

  public function read($input)
  {
    return $this->_read('Mutation', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('Mutation', self::$_TSPEC, $output);
  }
}

class cassandra_TokenRange extends TBase {
  static $_TSPEC;

  public $start_token = null;
  public $end_token = null;
  public $endpoints = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'start_token',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'end_token',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'endpoints',
          'type' => TType::LST,
          'etype' => TType::STRING,
          'elem' => array(
            'type' => TType::STRING,
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TokenRange';
  }

  public function read($input)
  {
    return $this->_read('TokenRange', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('TokenRange', self::$_TSPEC, $output);
  }
}

class cassandra_AuthenticationRequest extends TBase {
  static $_TSPEC;

  public $credentials = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'credentials',
          'type' => TType::MAP,
          'ktype' => TType::STRING,
          'vtype' => TType::STRING,
          'key' => array(
            'type' => TType::STRING,
          ),
          'val' => array(
            'type' => TType::STRING,
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'AuthenticationRequest';
  }

  public function read($input)
  {
    return $this->_read('AuthenticationRequest', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('AuthenticationRequest', self::$_TSPEC, $output);
  }
}

class cassandra_ColumnDef extends TBase {
  static $_TSPEC;

  public $name = null;
  public $validation_class = null;
  public $index_type = null;
  public $index_name = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'name',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'validation_class',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'index_type',
          'type' => TType::I32,
          ),
        4 => array(
          'var' => 'index_name',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'ColumnDef';
  }

  public function read($input)
  {
    return $this->_read('ColumnDef', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('ColumnDef', self::$_TSPEC, $output);
  }
}

class cassandra_CfDef extends TBase {
  static $_TSPEC;

  public $keyspace = null;
  public $name = null;
  public $column_type = "Standard";
  public $comparator_type = "BytesType";
  public $subcomparator_type = null;
  public $comment = null;
  public $row_cache_size = 0;
  public $key_cache_size = 200000;
  public $read_repair_chance = 1;
  public $column_metadata = null;
  public $gc_grace_seconds = null;
  public $default_validation_class = null;
  public $id = null;
  public $min_compaction_threshold = null;
  public $max_compaction_threshold = null;
  public $row_cache_save_period_in_seconds = null;
  public $key_cache_save_period_in_seconds = null;
  public $memtable_flush_after_mins = null;
  public $memtable_throughput_in_mb = null;
  public $memtable_operations_in_millions = null;
  public $replicate_on_write = null;
  public $merge_shards_chance = null;
  public $key_validation_class = null;
  public $row_cache_provider = "org.apache.cassandra.cache.ConcurrentLinkedHashCacheProvider";
  public $key_alias = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'keyspace',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'name',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'column_type',
          'type' => TType::STRING,
          ),
        5 => array(
          'var' => 'comparator_type',
          'type' => TType::STRING,
          ),
        6 => array(
          'var' => 'subcomparator_type',
          'type' => TType::STRING,
          ),
        8 => array(
          'var' => 'comment',
          'type' => TType::STRING,
          ),
        9 => array(
          'var' => 'row_cache_size',
          'type' => TType::DOUBLE,
          ),
        11 => array(
          'var' => 'key_cache_size',
          'type' => TType::DOUBLE,
          ),
        12 => array(
          'var' => 'read_repair_chance',
          'type' => TType::DOUBLE,
          ),
        13 => array(
          'var' => 'column_metadata',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => 'cassandra_ColumnDef',
            ),
          ),
        14 => array(
          'var' => 'gc_grace_seconds',
          'type' => TType::I32,
          ),
        15 => array(
          'var' => 'default_validation_class',
          'type' => TType::STRING,
          ),
        16 => array(
          'var' => 'id',
          'type' => TType::I32,
          ),
        17 => array(
          'var' => 'min_compaction_threshold',
          'type' => TType::I32,
          ),
        18 => array(
          'var' => 'max_compaction_threshold',
          'type' => TType::I32,
          ),
        19 => array(
          'var' => 'row_cache_save_period_in_seconds',
          'type' => TType::I32,
          ),
        20 => array(
          'var' => 'key_cache_save_period_in_seconds',
          'type' => TType::I32,
          ),
        21 => array(
          'var' => 'memtable_flush_after_mins',
          'type' => TType::I32,
          ),
        22 => array(
          'var' => 'memtable_throughput_in_mb',
          'type' => TType::I32,
          ),
        23 => array(
          'var' => 'memtable_operations_in_millions',
          'type' => TType::DOUBLE,
          ),
        24 => array(
          'var' => 'replicate_on_write',
          'type' => TType::BOOL,
          ),
        25 => array(
          'var' => 'merge_shards_chance',
          'type' => TType::DOUBLE,
          ),
        26 => array(
          'var' => 'key_validation_class',
          'type' => TType::STRING,
          ),
        27 => array(
          'var' => 'row_cache_provider',
          'type' => TType::STRING,
          ),
        28 => array(
          'var' => 'key_alias',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CfDef';
  }

  public function read($input)
  {
    return $this->_read('CfDef', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CfDef', self::$_TSPEC, $output);
  }
}

class cassandra_KsDef extends TBase {
  static $_TSPEC;

  public $name = null;
  public $strategy_class = null;
  public $strategy_options = null;
  public $replication_factor = null;
  public $cf_defs = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'name',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'strategy_class',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'strategy_options',
          'type' => TType::MAP,
          'ktype' => TType::STRING,
          'vtype' => TType::STRING,
          'key' => array(
            'type' => TType::STRING,
          ),
          'val' => array(
            'type' => TType::STRING,
            ),
          ),
        4 => array(
          'var' => 'replication_factor',
          'type' => TType::I32,
          ),
        5 => array(
          'var' => 'cf_defs',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => 'cassandra_CfDef',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'KsDef';
  }

  public function read($input)
  {
    return $this->_read('KsDef', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('KsDef', self::$_TSPEC, $output);
  }
}

class cassandra_CqlRow extends TBase {
  static $_TSPEC;

  public $key = null;
  public $columns = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'key',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'columns',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => 'cassandra_Column',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CqlRow';
  }

  public function read($input)
  {
    return $this->_read('CqlRow', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CqlRow', self::$_TSPEC, $output);
  }
}

class cassandra_CqlResult extends TBase {
  static $_TSPEC;

  public $type = null;
  public $rows = null;
  public $num = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'type',
          'type' => TType::I32,
          ),
        2 => array(
          'var' => 'rows',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => 'cassandra_CqlRow',
            ),
          ),
        3 => array(
          'var' => 'num',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CqlResult';
  }

  public function read($input)
  {
    return $this->_read('CqlResult', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CqlResult', self::$_TSPEC, $output);
  }
}

?>
