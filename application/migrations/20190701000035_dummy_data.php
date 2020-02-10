<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Dummy_data extends CI_Migration {

        public function up()
        {
                $this->insert_common_records();
        }

        private function insert_common_records()
        {
                $datatime_now = new DateTime('NOW', new DateTimeZone('UTC'));

                /* users */
                $dummy_records = array(
                        array(
                                'inserted_at' => $datatime_now->format('Y-m-d H:i:s'),
                                'username' => 'admin',
                                'firstname' => 'pavlos',
                                'lastname' => 'tiftikidis',
                                'email' => 'info@ptyxiakh.gr',
                                'password' => 'admin'
                        )
                );
                $this->db->insert_batch('users', $dummy_records);

                // $dummy_records = array(
                //         array(
                //                 'inserted_at' => $datatime_now->format('Y-m-d H:i:s'),
                //                 'email' => 'prof1@prof1.com',
                //                 'firstname' => 'thanasis',
                //                 'lastname' => 'tha',
                //                 'scholarid' => 'iNX_7Is'
                //         ),
                //         array(
                //                 'inserted_at' => $datatime_now->format('Y-m-d H:i:s'),
                //                 'email' => 'prof2@prof2.com',
                //                 'firstname' => 'iwannhs',
                //                 'lastname' => 'iwa',
                //                 'scholarid' => 'iNX_7Is'
                //         ),
                //         array(
                //                 'inserted_at' => $datatime_now->format('Y-m-d H:i:s'),
                //                 'email' => 'prof3@prof3.com',
                //                 'firstname' => 'pavlos',
                //                 'lastname' => 'pav',
                //                 'scholarid' => 'iNX_7Is'
                //         )
                // );
                // $this->db->insert_batch('professors', $dummy_records);    


                // $dummy_records = array(
                //         array(
                //                 'inserted_at' => $datatime_now->format('Y-m-d H:i:s'),
                //                 'title' => 'Epileptic seizure detection in EEGs using time–frequency analysis',
                //                 'publication_date' => '2009/3/16',
                //                 'type' => 'IEEE transactions on information technology in biomedicine',
                //                 'description' => 'The detection of recorded epileptic seizure activity in EEG segments is crucial for the localization and classification of epileptic seizures.',
                //                 'citation' => '466',
                //                 'scholarid_professor' => 'Jrpqo_QAAAAJ',
                //                 'scholarid_article' => 'u-x6o8ySG0sC' //url_article = Jrpqo_QAAAAJ:u-x6o8ySG0sC

                //         ),
                //         array(
                //                 'inserted_at' => $datatime_now->format('Y-m-d H:i:s'),
                //                 'title' => 'Epileptic seizure detection in EEGs using time–frequency analysis',
                //                 'publication_date' => '2009/3/16',
                //                 'journal' => 'IEEE transactions on information technology in biomedicine',
                //                 'description' => 'The detection of recorded epileptic seizure activity in EEG segments is crucial for the localization and classification of epileptic seizures.',
                //                 'citation' => '466',
                //                 'scholarid_professor' => 'Jrpqo_QAAAAJ',
                //                 'scholarid_article' => 'u-x6o8ySG0sC'
                //         )
                // );
                //$this->db->insert_batch('articles', $dummy_records);                  
        }

}