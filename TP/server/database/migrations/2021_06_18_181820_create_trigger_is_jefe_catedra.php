<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTriggerIsJefeCatedra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER is_jefe_catedra BEFORE INSERT ON catedras FOR EACH ROW
            BEGIN
                IF (select COUNT(*) 
                    from personas_roles pr INNER JOIN roles r on pr.id_rol = r.id 
                    WHERE pr.id_persona = new.id_jefe_catedra and r.descripcion = 'Jefe Catedra') = 0
                THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La persona no es jefe de cátedra';
                END IF;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER is_jefe_catedra");
    }
}
