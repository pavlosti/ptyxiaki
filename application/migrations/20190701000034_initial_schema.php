<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Initial_schema extends CI_Migration {
        private $tables;

        public function __construct()
        {
                parent::__construct();
                $this->load->dbforge();
        }

        public function up()
        {
                // Create Users table

                //$this->dbforge->drop_table($this->tables['users'], TRUE);
                $this->dbforge->add_field([
                        'id' => [
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ],
                        'email' => [
                                'type' => 'VARCHAR',
                                'constraint' => '50'
                        ],
                        'username' => [
                                'type' => 'VARCHAR',
                                'constraint' => '30'
                        ],
                        'firstname' => [
                                'type' => 'VARCHAR',
                                'constraint' => '30'
                        ],
                        'lastname' => [
                                'type' => 'VARCHAR',
                                'constraint' => '30'
                        ],
                        'password' => [
                                'type' => 'VARCHAR',
                                'constraint' => 50
                        ],
                        'inserted_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ],
                        'updated_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ],
                        'deleted_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ]
                ]);

                
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('users');


                // Create Professors table
                //$this->dbforge->drop_table($this->tables['professors'], TRUE);
                $this->dbforge->add_field([
                        'id' => [
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ],
                        'email' => [
                                'type' => 'VARCHAR',
                                'constraint' => '50'
                        ],
                        'firstname' => [
                                'type' => 'VARCHAR',
                                'constraint' => '30'
                        ],
                        'lastname' => [
                                'type' => 'VARCHAR',
                                'constraint' => '30'
                        ],
                        'scholarid' => [
                                'type' => 'VARCHAR',
                                'constraint' => '50',
                                'null' => TRUE
                        ],
                        'citation_on_web' => [
                                'type' => 'INT',
                                'constraint' => '50',
                                'null' => TRUE
                        ],
                        'citation_on_db' => [
                                'type' => 'INT',
                                'constraint' => '50',
                                'null' => TRUE
                        ],
                        'last_article_update_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ],
                        'last_ref_update_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ],
                        'inserted_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ],
                        'updated_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ],
                        'deleted_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ]
                ]);

                
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('professors');


                // Create Scientific articles table
                //$this->dbforge->drop_table($this->tables['articles'], TRUE);
                $this->dbforge->add_field([
                        'id' => [
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ],
                        'title' => [
                                'type' => 'VARCHAR',
                                'constraint' => '100'
                        ],
                        'publication_date' => [
                                'type' => 'VARCHAR',
                                'constraint' => '10',
                                'null' => TRUE
                        ],
                        'month' => [
                                'type' => 'INT',
                                'null' => TRUE
                        ],
                        'year' => [
                                'type' => 'YEAR',
                                'null' => TRUE
                        ],
                        'type_name' => [
                                'type' => 'VARCHAR',
                                'constraint' => '50',
                                'null' => TRUE
                        ],
                        'type' => [
                                'type' => 'VARCHAR',
                                'constraint' => '50',
                                'null' => TRUE
                        ],
                        'volume' => [
                                'type' => 'VARCHAR',
                                'constraint' => '10',
                                'null' => TRUE
                        ],
                        'issue' => [
                                'type' => 'VARCHAR',
                                'constraint' => '10',
                                'null' => TRUE
                        ],
                        'pages' => [
                                'type' => 'VARCHAR',
                                'constraint' => '20',
                                'null' => TRUE
                        ],
                        'publisher' => [
                                'type' => 'VARCHAR',
                                'constraint' => '30',
                                'null' => TRUE
                        ],
                        'description' => [
                                'type' => 'VARCHAR',
                                'constraint' => '200',
                                'null' => TRUE
                        ],
                        'citation' => [
                                'type' => 'INT',
                                'constraint' => '50',
                                'null' => TRUE
                        ],
                        'references_id' => [
                                'type' => 'VARCHAR',
                                'constraint' => '50',
                                'null' => TRUE
                        ],
                        'scholarid_professor' => [
                                'type' => 'VARCHAR',
                                'constraint' => '50'
                        ],
                        'scholarid_article' => [
                                'type' => 'VARCHAR',
                                'constraint' => '50'
                        ],
                        'inserted_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ],
                        'updated_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ],
                        'deleted_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ]
                ]);

                
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('articles');
        



                $this->dbforge->add_field([
                        'id' => [
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ],
                        'title' => [
                                'type' => 'VARCHAR',
                                'null' => TRUE,
                                'constraint' => '200'
                        ],
                        'bibtex_id' => [
                                'type' => 'VARCHAR',
                                'null' => TRUE,
                                'constraint' => '40'
                        ],
                        'ref_id' => [
                                'type' => 'VARCHAR',
                                'null' => FALSE,
                                'constraint' => '40'
                        ],
                        'publishers' => [
                                'type' => 'VARCHAR',
                                'null' => TRUE,
                                'constraint' => '200'
                        ],
                        'year' => [
                                'type' => 'VARCHAR',
                                'null' => TRUE,
                                'constraint' => '10'
                        ],
                        'scholarid_article' => [
                                'type' => 'VARCHAR',
                                'constraint' => '50'
                        ],
                        'inserted_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ],
                        'updated_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ],
                        'deleted_at' => [
                                'type' => 'date',
                                'null' => TRUE
                        ]
                ]);

                
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('references');
        }

        public function down()
        {
                $this->dbforge->drop_table('users');
                $this->dbforge->drop_table('professors');
                $this->dbforge->drop_table('articles');
                $this->dbforge->drop_table('references');
        }
}