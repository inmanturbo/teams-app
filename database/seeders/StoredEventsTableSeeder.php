<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StoredEventsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run(): void
    {
        

        \DB::table('stored_events')->delete();
        
        \DB::table('stored_events')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_uuid' => NULL,
                'team_uuid' => NULL,
                'owner_uuid' => NULL,
                'aggregate_uuid' => 'dfed21bf-c73b-4136-8807-21b031555ba3',
                'aggregate_version' => 1,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\UserCreated::class,
                'event_properties' => '{"userUuid":"dfed21bf-c73b-4136-8807-21b031555ba3","name":"admin","email":"admin@admin.com","password":"$2y$10$a5jgy2BuOv6eAbkfja16Q.tbLpy5q6g4FQCKwDQLChntn6aTwVHZa","withPersonalTeam":false,"teamUuid":null,"teamName":null,"teamDatabaseUuid":null}',
                'meta_data' => '{"aggregate-root-uuid":"dfed21bf-c73b-4136-8807-21b031555ba3","created-at":"2023-02-03T23:21:31.773943Z","aggregate-root-version":1,"stored-event-id":1}',
                'created_at' => '2023-02-03 18:21:31',
            ),
            1 => 
            array (
                'id' => 2,
                'user_uuid' => 'dfed21bf-c73b-4136-8807-21b031555ba3',
                'team_uuid' => NULL,
                'owner_uuid' => NULL,
                'aggregate_uuid' => '2c45b23d-0516-48b4-a514-13d3587fcaff',
                'aggregate_version' => 1,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\TeamDatabaseCreated::class,
                'event_properties' => '{"databaseUuid":"2c45b23d-0516-48b4-a514-13d3587fcaff","userUuid":"dfed21bf-c73b-4136-8807-21b031555ba3","name":"my_db","driver":null}',
                'meta_data' => '{"aggregate-root-uuid":"2c45b23d-0516-48b4-a514-13d3587fcaff","created-at":"2023-02-04T00:47:54.391756Z","aggregate-root-version":1,"stored-event-id":2}',
                'created_at' => '2023-02-03 19:47:54',
            ),
            2 => 
            array (
                'id' => 3,
                'user_uuid' => 'dfed21bf-c73b-4136-8807-21b031555ba3',
                'team_uuid' => NULL,
                'owner_uuid' => NULL,
                'aggregate_uuid' => 'b7fd4d4a-14c2-4be3-9495-99bb75075c61',
                'aggregate_version' => 1,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\TeamCreated::class,
                'event_properties' => '{"teamUuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","name":"Admin\'s Team","ownerUuid":"dfed21bf-c73b-4136-8807-21b031555ba3","teamDatabaseUuid":"2c45b23d-0516-48b4-a514-13d3587fcaff","personalTeam":false}',
                'meta_data' => '{"aggregate-root-uuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","created-at":"2023-02-04T00:48:43.064892Z","aggregate-root-version":1,"stored-event-id":3}',
                'created_at' => '2023-02-03 19:48:43',
            ),
            3 => 
            array (
                'id' => 4,
                'user_uuid' => 'dfed21bf-c73b-4136-8807-21b031555ba3',
                'team_uuid' => 'b7fd4d4a-14c2-4be3-9495-99bb75075c61',
                'owner_uuid' => 'dfed21bf-c73b-4136-8807-21b031555ba3',
                'aggregate_uuid' => 'b7fd4d4a-14c2-4be3-9495-99bb75075c61',
                'aggregate_version' => 2,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\TeamMemberInvited::class,
                'event_properties' => '{"teamUuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","email":"supervisor@supervisor.com","role":"supervisor","invitationUuid":"928aaed9-ad02-44f1-a14a-0bac00171304"}',
                'meta_data' => '{"aggregate-root-uuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","created-at":"2023-02-04T00:49:28.827536Z","aggregate-root-version":2,"stored-event-id":4}',
                'created_at' => '2023-02-03 19:49:28',
            ),
            4 => 
            array (
                'id' => 5,
                'user_uuid' => NULL,
                'team_uuid' => NULL,
                'owner_uuid' => NULL,
                'aggregate_uuid' => '557e728f-8e8f-472c-aa20-f6e977427e56',
                'aggregate_version' => 1,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\UserCreated::class,
                'event_properties' => '{"userUuid":"557e728f-8e8f-472c-aa20-f6e977427e56","name":"supervisor","email":"supervisor@supervisor.com","password":"$2y$10$RZqK7BGZGG0VN\\/z6cBMDS.Phax2jv2KMKK3xy6YrKRSsyZbraJPSK","withPersonalTeam":false,"teamUuid":null,"teamName":null,"teamDatabaseUuid":null}',
                'meta_data' => '{"aggregate-root-uuid":"557e728f-8e8f-472c-aa20-f6e977427e56","created-at":"2023-02-04T00:51:03.790746Z","aggregate-root-version":1,"stored-event-id":5}',
                'created_at' => '2023-02-03 19:51:03',
            ),
            5 => 
            array (
                'id' => 6,
                'user_uuid' => '557e728f-8e8f-472c-aa20-f6e977427e56',
                'team_uuid' => NULL,
                'owner_uuid' => NULL,
                'aggregate_uuid' => 'b7fd4d4a-14c2-4be3-9495-99bb75075c61',
                'aggregate_version' => 3,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\TeamMemberAdded::class,
                'event_properties' => '{"teamUuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","email":"supervisor@supervisor.com","role":"supervisor"}',
                'meta_data' => '{"aggregate-root-uuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","created-at":"2023-02-04T00:51:04.201469Z","aggregate-root-version":3,"stored-event-id":6}',
                'created_at' => '2023-02-03 19:51:04',
            ),
            6 => 
            array (
                'id' => 7,
                'user_uuid' => '557e728f-8e8f-472c-aa20-f6e977427e56',
                'team_uuid' => NULL,
                'owner_uuid' => NULL,
                'aggregate_uuid' => '557e728f-8e8f-472c-aa20-f6e977427e56',
                'aggregate_version' => 2,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\UserSwitchedTeam::class,
                'event_properties' => '{"userUuid":"557e728f-8e8f-472c-aa20-f6e977427e56","teamUuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61"}',
                'meta_data' => '{"aggregate-root-uuid":"557e728f-8e8f-472c-aa20-f6e977427e56","created-at":"2023-02-04T00:51:04.271041Z","aggregate-root-version":2,"stored-event-id":7}',
                'created_at' => '2023-02-03 19:51:04',
            ),
            7 => 
            array (
                'id' => 8,
                'user_uuid' => 'dfed21bf-c73b-4136-8807-21b031555ba3',
                'team_uuid' => 'b7fd4d4a-14c2-4be3-9495-99bb75075c61',
                'owner_uuid' => 'dfed21bf-c73b-4136-8807-21b031555ba3',
                'aggregate_uuid' => 'b7fd4d4a-14c2-4be3-9495-99bb75075c61',
                'aggregate_version' => 4,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\TeamMemberInvited::class,
                'event_properties' => '{"teamUuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","email":"workforce@workforce.com","role":"workforce","invitationUuid":"b8533421-01d5-4721-aadf-479e88db1901"}',
                'meta_data' => '{"aggregate-root-uuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","created-at":"2023-02-04T00:52:13.806107Z","aggregate-root-version":4,"stored-event-id":8}',
                'created_at' => '2023-02-03 19:52:13',
            ),
            8 => 
            array (
                'id' => 9,
                'user_uuid' => 'dfed21bf-c73b-4136-8807-21b031555ba3',
                'team_uuid' => 'b7fd4d4a-14c2-4be3-9495-99bb75075c61',
                'owner_uuid' => 'dfed21bf-c73b-4136-8807-21b031555ba3',
                'aggregate_uuid' => 'b7fd4d4a-14c2-4be3-9495-99bb75075c61',
                'aggregate_version' => 5,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\TeamMemberInvited::class,
                'event_properties' => '{"teamUuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","email":"client@client.com","role":"client","invitationUuid":"391dba38-42ec-4287-97b3-8fd323def823"}',
                'meta_data' => '{"aggregate-root-uuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","created-at":"2023-02-04T00:52:25.477896Z","aggregate-root-version":5,"stored-event-id":9}',
                'created_at' => '2023-02-03 19:52:25',
            ),
            9 => 
            array (
                'id' => 10,
                'user_uuid' => NULL,
                'team_uuid' => NULL,
                'owner_uuid' => NULL,
                'aggregate_uuid' => 'd1cc7c05-b96b-4a58-a90c-744039240cee',
                'aggregate_version' => 1,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\UserCreated::class,
                'event_properties' => '{"userUuid":"d1cc7c05-b96b-4a58-a90c-744039240cee","name":"client","email":"client@client.com","password":"$2y$10$hn.feA2qxC\\/T.LYmF.3ybeemG6dxLmSBctsZvp5n0cxtwmvcVEGCW","withPersonalTeam":false,"teamUuid":null,"teamName":null,"teamDatabaseUuid":null}',
                'meta_data' => '{"aggregate-root-uuid":"d1cc7c05-b96b-4a58-a90c-744039240cee","created-at":"2023-02-04T00:54:00.586520Z","aggregate-root-version":1,"stored-event-id":10}',
                'created_at' => '2023-02-03 19:54:00',
            ),
            10 => 
            array (
                'id' => 11,
                'user_uuid' => 'd1cc7c05-b96b-4a58-a90c-744039240cee',
                'team_uuid' => NULL,
                'owner_uuid' => NULL,
                'aggregate_uuid' => 'b7fd4d4a-14c2-4be3-9495-99bb75075c61',
                'aggregate_version' => 6,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\TeamMemberAdded::class,
                'event_properties' => '{"teamUuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","email":"client@client.com","role":"client"}',
                'meta_data' => '{"aggregate-root-uuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","created-at":"2023-02-04T00:56:28.293579Z","aggregate-root-version":6,"stored-event-id":11}',
                'created_at' => '2023-02-03 19:56:28',
            ),
            11 => 
            array (
                'id' => 12,
                'user_uuid' => 'd1cc7c05-b96b-4a58-a90c-744039240cee',
                'team_uuid' => NULL,
                'owner_uuid' => NULL,
                'aggregate_uuid' => 'd1cc7c05-b96b-4a58-a90c-744039240cee',
                'aggregate_version' => 2,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\UserSwitchedTeam::class,
                'event_properties' => '{"userUuid":"d1cc7c05-b96b-4a58-a90c-744039240cee","teamUuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61"}',
                'meta_data' => '{"aggregate-root-uuid":"d1cc7c05-b96b-4a58-a90c-744039240cee","created-at":"2023-02-04T00:56:28.366904Z","aggregate-root-version":2,"stored-event-id":12}',
                'created_at' => '2023-02-03 19:56:28',
            ),
            12 => 
            array (
                'id' => 13,
                'user_uuid' => NULL,
                'team_uuid' => NULL,
                'owner_uuid' => NULL,
                'aggregate_uuid' => '5f8aa0d0-381b-49ca-b368-20a0af2834d3',
                'aggregate_version' => 1,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\UserCreated::class,
                'event_properties' => '{"userUuid":"5f8aa0d0-381b-49ca-b368-20a0af2834d3","name":"workforce","email":"workforce@workforce.com","password":"$2y$10$Wo25Su9LZnSWomhCsKfvpuRIr\\/cT\\/tKuhI1RjK6jxY4ap51KBsb4K","withPersonalTeam":false,"teamUuid":null,"teamName":null,"teamDatabaseUuid":null}',
                'meta_data' => '{"aggregate-root-uuid":"5f8aa0d0-381b-49ca-b368-20a0af2834d3","created-at":"2023-02-04T00:58:32.917156Z","aggregate-root-version":1,"stored-event-id":13}',
                'created_at' => '2023-02-03 19:58:32',
            ),
            13 => 
            array (
                'id' => 14,
                'user_uuid' => '5f8aa0d0-381b-49ca-b368-20a0af2834d3',
                'team_uuid' => NULL,
                'owner_uuid' => NULL,
                'aggregate_uuid' => 'b7fd4d4a-14c2-4be3-9495-99bb75075c61',
                'aggregate_version' => 7,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\TeamMemberAdded::class,
                'event_properties' => '{"teamUuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","email":"workforce@workforce.com","role":"workforce"}',
                'meta_data' => '{"aggregate-root-uuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61","created-at":"2023-02-04T00:58:33.472759Z","aggregate-root-version":7,"stored-event-id":14}',
                'created_at' => '2023-02-03 19:58:33',
            ),
            14 => 
            array (
                'id' => 15,
                'user_uuid' => '5f8aa0d0-381b-49ca-b368-20a0af2834d3',
                'team_uuid' => NULL,
                'owner_uuid' => NULL,
                'aggregate_uuid' => '5f8aa0d0-381b-49ca-b368-20a0af2834d3',
                'aggregate_version' => 2,
                'event_version' => 1,
                'event_class' => \App\StorableEvents\UserSwitchedTeam::class,
                'event_properties' => '{"userUuid":"5f8aa0d0-381b-49ca-b368-20a0af2834d3","teamUuid":"b7fd4d4a-14c2-4be3-9495-99bb75075c61"}',
                'meta_data' => '{"aggregate-root-uuid":"5f8aa0d0-381b-49ca-b368-20a0af2834d3","created-at":"2023-02-04T00:58:33.560198Z","aggregate-root-version":2,"stored-event-id":15}',
                'created_at' => '2023-02-03 19:58:33',
            ),
        ));
        
        
    }
}