/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.company.pollweb.utility;

import com.company.pollweb.data.models.Domanda;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.concurrent.atomic.AtomicBoolean;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 *
 * @author alessandrodorazio
 */
public class ValidazioneCampi {
    public static boolean emailPattern(String email) {
        //pattern e matcher per verificare se l'email è in un formato corretto
        Pattern emailPattern = Pattern.compile("^(.+)@(.+)$");
        Matcher matcher = emailPattern.matcher(email);
        return matcher.matches();
    }

    public static boolean checkCampoCompilazione(Domanda domanda, JSONArray risposta) {
        switch(domanda.getTipologia()) {
            case "testo_breve":
                return checkTestoBreve(domanda, risposta);
            case "testo_lungo":
                return checkTestoLungo(domanda, risposta);
            case "numero":
                return checkNumero(domanda, risposta);
            case "data":
                return checkData(domanda, risposta);
            case "scelta_singola":
                return checkSceltaSingola(domanda, risposta);
            case "scelta_multipla":
                return checkSceltaMultipla(domanda, risposta);
        }
        return true;
    }

    public static boolean checkTestoBreve(Domanda domanda, JSONArray risposta) {
        return checkTesto(domanda, risposta);
    }

    public static boolean checkTestoLungo(Domanda domanda, JSONArray risposta) {
        return checkTesto(domanda, risposta);
    }

    private static boolean checkTesto(Domanda domanda, JSONArray risposta) {
        AtomicBoolean valido = new AtomicBoolean(true);
        int min_length = domanda.getMin_length();
        int max_length = domanda.getMax_length();
        String pattern = domanda.getPattern();
        risposta.forEach(valore -> {
            String valoreStringa = valore.toString();

            //controllo lunghezza minima
            if(domanda.getVincoli().has("min_length")) {
                if(valoreStringa.length() < min_length) {
                    valido.set(false);
                }
            }

            //controllo lunghezza massima
            if(domanda.getVincoli().has("max_length")) {
                if(valoreStringa.length() > max_length) {
                    valido.set(false);
                }
            }

            //controllo pattern
            if(domanda.getVincoli().has("pattern") && pattern.length() > 0) {
                Pattern testoPattern = Pattern.compile(pattern);
                Matcher matcher = testoPattern.matcher(valoreStringa);
                if(!matcher.matches()) {
                    valido.set(false);
                }
            }

        });
        return valido.get();
    }

    public static boolean checkNumero(Domanda domanda, JSONArray risposta) {
        AtomicBoolean valido = new AtomicBoolean(true);
        int min_num = domanda.getMin_num();
        int max_num = domanda.getMax_num();
        risposta.forEach(valore -> {
            int valoreIntero = Integer.parseInt(valore.toString());

            if(domanda.getVincoli().has("min_num")) {
                if(valoreIntero < min_num) {
                    valido.set(false);
                }
            }

            if(domanda.getVincoli().has("max_num")) {
                if(valoreIntero > max_num) {
                    valido.set(false);
                }
            }


        });
        return valido.get();
    }

    public static boolean checkData(Domanda domanda, JSONArray risposta) {
        return true;
    }

    public static boolean checkSceltaSingola(Domanda domanda, JSONArray risposta) {
        //TODO conviene fare un check se quell'elemento che è stato inserito fa parte delle possibili scelte?
        return true;
    }

    public static boolean checkSceltaMultipla(Domanda domanda, JSONArray risposta) {
        //TODO conviene fare un check se quell'elemento che è stato inserito fa parte delle possibili scelte?
        AtomicBoolean valido = new AtomicBoolean(true);
        int min_chooses = domanda.getMin_chooses();
        int max_chooses = domanda.getMax_chooses();
        if(min_chooses > 0) {
            if(risposta.length() < min_chooses){
                valido.set(false);
            }
        }

        if(max_chooses > 0) {
            if(risposta.length() > max_chooses) {
                valido.set(false);
            }
        }

        return valido.get();
    }

}
