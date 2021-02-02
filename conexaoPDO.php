<?php

abstract class ConexaoBD {

    private static $instance;

    public static function getInstance() {

        try {
            if (!isset(self::$instance)) {
                self::$instance = new PDO("mysql:host=localhost;dbname=bancocep;charset=UTF8", "root", "");
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$instance;
        } catch (PDOException $exc) {
            echo "Erro ao conectar o banco de dados :" . $exc->getMessage();
        }
    }

}
