/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.company.pollweb.framework.security;

import java.util.HashMap;
import java.util.Iterator;
import java.util.LinkedList;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import javax.servlet.http.HttpServletRequest;

/**
 *
 * @author Marco Ovidi
 */
public class Validator {
    private LinkedList<ValidationField> validations;

    public Validator(LinkedList<ValidationField> validations) {
        this.validations = validations;
    }

    public Validator() {
        validations = new LinkedList<>();
    }

    public void addValidationRules(String nome, String espressioneRegolare, int tipoCampo) {
        ValidationField field = new ValidationField(nome, espressioneRegolare, tipoCampo);
        validations.add(field);
    }

    public HashMap<String, Object> validaParametri(HttpServletRequest request) {
        HashMap<String, Object> result = new HashMap<>();
        HashMap<String, Object> validatedFields = new HashMap<>();
        Boolean correct = true;


        Iterator<ValidationField> itr = validations.iterator();


        while (itr.hasNext()) {
            ValidationField validator = itr.next();

            String parameter = request.getParameter(validator.getNomeCampo());
            System.err.println("VALORE PARAMETRO INPUT: " + parameter);

            Pattern pattern = Pattern.compile(validator.getEspressioneRegolare());

            if (parameter != null && !parameter.equals("")) {
                Matcher m = pattern.matcher(parameter);

                if (m.find()) {
                    parameter = sanitizeHTMLOutput(parameter);

                    switch (validator.getTipoCampo()) {
                        case 0:
                            validatedFields.put(validator.getNomeCampo(), parameter);
                            break;
                        case 1:
                            validatedFields.put(validator.getNomeCampo(), Integer.valueOf(SecurityLayer.checkNumeric(parameter)));
                            break;
                        case 2:
                            validatedFields.put(validator.getNomeCampo(), Boolean.valueOf(parameter));
                            break;
                        default:
                            validatedFields.put(validator.getNomeCampo(), parameter);
                            break;
                    }
                } else {
                    System.out.println(validator.getNomeCampo() + "   VALIDAZIONE ERRONEA");
                    validatedFields.put(validator.getNomeCampo(), null);
                    correct = false;
                }
            } else {
                //System.out.println("ARRIVATO NULLO:" + validator.getNomeCampo());
                validatedFields.put(validator.getNomeCampo(), null);
                correct = false;
            }

        }

        result.put("fields", validatedFields);
        result.put("statoValidazione", correct);

        return result;


    }


    /**
     * Sanitizzazione dell'input
     *
     * @param s
     * @return
     */
    public static String sanitizeHTMLOutput(String s) {
        return s.replaceAll("&", "&amp;")
                .replaceAll("<", "&lt;")
                .replaceAll("<", "&gt;")
                .replaceAll("'", "&#039;")
                .replaceAll("\"", "&#034;");
    }
}