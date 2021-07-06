<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER validar_vacantes BEFORE INSERT ON llamados FOR EACH ROW
            BEGIN
                IF NEW.vacantes < 1 OR NEW.vacantes > 100
                THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El número de vacantes debe estar entre 1 y 100';
                END IF;
            END;

            CREATE TRIGGER validar_puntaje BEFORE INSERT ON postulaciones FOR EACH ROW
            BEGIN
                IF NEW.puntaje < 1 OR NEW.puntaje > 100
                THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El puntaje debe estar entre 1 y 100';
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
        DB::unprepared("DROP TRIGGER IF EXISTS validar_vacantes;
                        DROP TRIGGER IF EXISTS validar_puntaje;");
    }
}
