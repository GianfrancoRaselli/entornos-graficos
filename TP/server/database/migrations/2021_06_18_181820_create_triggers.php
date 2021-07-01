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
            CREATE TRIGGER is_jefe_catedra BEFORE INSERT ON catedras FOR EACH ROW
            BEGIN
                IF (select COUNT(*) 
                    from personas_roles pr INNER JOIN roles r on pr.id_rol = r.id 
                    WHERE pr.id_persona = new.id_jefe_catedra and r.descripcion = 'Jefe Catedra') = 0
                THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La persona no es jefe de cátedra';
                END IF;
            END;

            CREATE TRIGGER insert_jefe_catedra AFTER INSERT ON catedras FOR EACH ROW
            BEGIN
                INSERT INTO personas_catedras (id_persona, id_catedra) VALUES (NEW.id_jefe_catedra, NEW.id);
            END;

            CREATE TRIGGER delete_jefe_catedra BEFORE DELETE ON catedras FOR EACH ROW
            BEGIN
                DELETE FROM personas_catedras WHERE id_persona=OLD.id_jefe_catedra AND id_catedra=OLD.id;
            END;

            CREATE TRIGGER update_jefe_catedra AFTER UPDATE ON catedras FOR EACH ROW
            BEGIN
                IF OLD.id_jefe_catedra <> NEW.id_jefe_catedra
                THEN
                    BEGIN
                        DELETE FROM personas_catedras WHERE id_persona=OLD.id_jefe_catedra AND id_catedra=OLD.id;
                        INSERT INTO personas_catedras (id_persona, id_catedra) VALUES (NEW.id_jefe_catedra, NEW.id);
                    END;
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
        DB::unprepared("DROP TRIGGER IF EXISTS is_jefe_catedra;
                        DROP TRIGGER IF EXISTS insert_jefe_catedra;
                        DROP TRIGGER IF EXISTS delete_jefe_catedra;
                        DROP TRIGGER IF EXISTS update_jefe_catedra;");
    }
}
