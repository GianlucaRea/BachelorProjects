package com.company.pollweb.controllers;

import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.models.Utente;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.TemplateManagerException;
import com.company.pollweb.framework.result.TemplateResult;
import com.company.pollweb.framework.security.SecurityLayer;

import com.company.pollweb.framework.security.Validator;
import org.jasypt.util.password.BasicPasswordEncryptor;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.util.HashMap;

public class Registrazione extends PollWebBaseController{

    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     */
    @Override
    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException {
        renderizza_form_registrazione(request, response);
        HttpSession session = SecurityLayer.checkSession(request);
        if(session == null){
            if (request.getParameter("register") != null) {
                 action_register_utente(request, response);
            } else {
                //propone il template per riempire la form di registrazione
                renderizza_form_registrazione(request, response);
            }
        }else{
                //TODO Handle Exception
        }
    }

    private void action_register_utente(HttpServletRequest request, HttpServletResponse response) {
        PollwebDataLayer dl = ((PollwebDataLayer)request.getAttribute("datalayer"));

        //espressioni regolari per la validazione dei campi
        String REGEXP_PASSWORD = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[#$^+=!*()@%&]).{8,30}$";
        String REGEXP_EMAIL = "^[\\w!#$%&’*+/=?`{|}~^-]+(?:\\.[\\w!#$%&’*+/=?`{|}~^-]+)*@(?:[a-zA-Z0-9-]+\\.)+[a-zA-Z]{2,6}$";
        String REGEXP_STRING = ".{2,}";
        String REGEXP_SELECT = "^(?:si\\b|no\\b)";

        //preparazione del validatore
        Validator validator = new Validator();
        //campi del validatore
        validator.addValidationRules("inputEmail",REGEXP_EMAIL,0);
        validator.addValidationRules("inputPassword",REGEXP_PASSWORD,0);
        validator.addValidationRules("inputRepeatPassword",REGEXP_PASSWORD,0);
        validator.addValidationRules("inputNome", REGEXP_STRING, 0);
        validator.addValidationRules("inputCognome", REGEXP_STRING, 0);
        validator.addValidationRules("inputResponsabile", REGEXP_SELECT, 0);

        //risultato del validatore
        HashMap<String,Object> validated = validator.validaParametri(request);
        //campi validati
        HashMap<String,Object> fields = ((HashMap < String, Object>)validated.get("fields"));
        System.out.println(fields);
        System.out.println(validated.get("statoValidazione"));
        //ci sono errori di validazione rimando alla form con campi corretti riempiti e gli altri vuoti
        //NOTA: si devo far apparire gli errori in qualche MODO
        if(! ((Boolean)validated.get("statoValidazione"))){
            TemplateResult t = new TemplateResult(getServletContext());
            try {
                fields.put("error", true);
                t.activate("registrazione.ftl", fields, response, request);
            } catch (TemplateManagerException ex) {
                // TODO Handle Exception
          }
        }else{
            //nn ci sono errori si può procedere all'inserimento se le password fanno matching
            if(fields.get("inputPasswordS").equals(fields.get("inputRepeatPasswordS"))){
                try {
                    //password uguali procedo
                    //controllo se non è già inserito il tutor nel db
                    if(dl.getUtenteDAO().getUtenteByEmail(((String)fields.get("inputEmail"))) != null){
                        TemplateResult t = new TemplateResult(getServletContext());
                        HashMap<String,Object> fieldsAndError = new HashMap<>();
                        fieldsAndError.putAll(fields);
                        fieldsAndError.put("errore", "Attenzione l'utente è già registrato ");
                        fields.put("inputEmail", null);
                        try {
                            t.activate("registrazione.ftl", fieldsAndError, response, request);
                        } catch (TemplateManagerException ex) {
                            //TODO Gestire L'eccezzione
                        }
                    }else{
                        //creo il nuovo utente
                        Utente utente = dl.getUtenteDAO().creaUtente();

                        //riempio il costruttore
                        utente.setNome(((String)fields.get("inputNome")));
                        utente.setCognome(((String)fields.get("inputCognome")));
                        utente.setEmail(((String)fields.get("inputEmail")));
                        utente.setPassword(new BasicPasswordEncryptor().encryptPassword(((String)fields.get("inputPassword"))));
                        utente.setRuolo(((int)fields.get("inputResponsabile")));


                        //rendo persistente lo studente
                        dl.getUtenteDAO().salvaUtente(utente);
                        HashMap<String,Object> model = new HashMap<>();
                        model.put("succes",true);
                        model.put("utenteRegistrato",true);
                        TemplateResult tr = new TemplateResult(getServletContext());
                        tr.activate("auth/login.ftl", model, response, request);
                    }

                } catch (TemplateManagerException | DataException ex) {
                        // TODO Handle Exception
                }
            }else{
                //annullo i due campi per far risultare l'errore
                fields.put("inputPassword", null);
                fields.put("inputRepeatPassword", null);
                fields.put("error", true);
                //richiamo la form di registrazione
                TemplateResult t = new TemplateResult(getServletContext());
                try {
                    t.activate("registrazione.ftl", fields, response, request);
                } catch (TemplateManagerException ex) {
                    // TODO Handle Exception
                }
            }
        }

    }

    private void renderizza_form_registrazione(HttpServletRequest request, HttpServletResponse response) {
        TemplateResult res = new TemplateResult(getServletContext());
        try {
            res.activate("/registrazione.ftl",null, response,request);
        } catch (TemplateManagerException ex){
            // TODO Handle Exception
        }

    }

}
