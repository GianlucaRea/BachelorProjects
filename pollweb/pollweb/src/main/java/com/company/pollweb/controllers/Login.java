package com.company.pollweb.controllers;


import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.models.Utente;
import  com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.TemplateManagerException;
import com.company.pollweb.framework.result.TemplateResult;
import com.company.pollweb.framework.security.SecurityLayer;
import org.jasypt.util.password.BasicPasswordEncryptor;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.net.URLEncoder;
import java.util.HashMap;
import java.util.Map;


public class Login extends PollWebBaseController {

    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     */
    @Override
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException{
        try{
            //controllo se l'utente è già in sessione

            if(SecurityLayer.checkSession(request) != null){
                response.sendRedirect("/home?success=300");
            }
            if("POST".equals(request.getMethod())) {
                String email = SecurityLayer.addSlashes(request.getParameter("email").toLowerCase());
                PollwebDataLayer dl = ((PollwebDataLayer)request.getAttribute("datalayer"));
                if(email != null && ! email.equals("")){
                    if(dl.getUtenteDAO().getUtenteByEmail(email) != null){
                        action_login_utente(request,response);
                    }else{

                        response.sendRedirect("/login?error=200");
                    }

                }
            }


            if(request.getParameter("login") != null){
                try{
                    String referrer = null;
                    if(request.getParameter("referrer") != null){
                        referrer = SecurityLayer.addSlashes(request.getParameter("referrer"));
                        request.setAttribute("referrer", referrer);
                    }
                    String email =" ";
                    PollwebDataLayer dl = ((PollwebDataLayer)request.getAttribute("datalayer"));
                    if(email != null && ! email.equals("")){
                        if(dl.getUtenteDAO().getUtenteByEmail(email) != null){
                            action_login_utente(request,response);
                        }else{
                            if(referrer != null){
                                response.sendRedirect("/login?referrer=" + URLEncoder.encode(referrer, "UTF-8"));
                            }else{
                                response.sendRedirect("/login?error=200");
                            }
                        }
                    }else{
                        if(referrer != null){
                            response.sendRedirect("/login?referrer=" + URLEncoder.encode(referrer, "UTF-8"));
                        }else{
                            response.sendRedirect("/login?error=200");
                        }
                    }
                } catch (DataException ex) {
                    //TODO Handle exception
                }
            }else{
                //rimando alla pagina di login per riempire la form di login
                renderizza_form_login(request,response);
            }
        }catch (IOException | DataException ex) {
            //TODO Handle exception
        }
    }

    private void renderizza_form_login(HttpServletRequest request, HttpServletResponse response) {
        TemplateResult r = new TemplateResult(getServletContext());
        try {
            Map data = new HashMap();
            if (request.getParameter("error") != null) {
                String errorMessage = "Operazione fallita";
                switch (request.getParameter("error")) {
                    case "100":
                        errorMessage = "Credenziali errate";
                        break;
                    case "101":
                        errorMessage = "Compila tutti i campi";
                        break;
                    case "102":
                        errorMessage = "Utente non trovato";
                        break;
                    case "200":
                        errorMessage= "Devi essere loggato per effettuare questa operazione";
                        break;

                }
                request.setAttribute("error", errorMessage);
            }
            r.activate("auth/login.ftl", data, response,request);
        } catch (TemplateManagerException ex) {
            //TODO Handle exception
        }
    }

    /**
     * Effettua il login come utente
     * @param request
     * @param response
     */
    private void action_login_utente(HttpServletRequest request, HttpServletResponse response) throws IOException{
        //recupero credenziali di login
        String email = SecurityLayer.addSlashes(request.getParameter("email").toLowerCase());
        email = SecurityLayer.sanitizeHTMLOutput(email);
        String password = SecurityLayer.addSlashes(request.getParameter("password"));
        password = SecurityLayer.sanitizeHTMLOutput(password);
        if(!email.isEmpty() && !password.isEmpty()){
            try {
                //recupero utente dal db
                Utente u = ((PollwebDataLayer)request.getAttribute("datalayer")).getUtenteDAO().getUtenteByEmail(email);
                //controllo che l'utente esista
                if(u != null){
                    //controllo i parametri
                    if(u.getEmail().equalsIgnoreCase(email) && new BasicPasswordEncryptor().checkPassword(password, u.getPassword())){
                        //se l'utente esiste ed è lui

                        request.setAttribute("userName", u.getNome());
                        request.setAttribute("user_id", u.getId());
                        System.out.println(u.getId());

                        SecurityLayer.createSession(request, u.getId());

                        if (request.getParameter("referrer") != null) {
                            response.sendRedirect(request.getParameter("referrer"));
                        } else {
                            response.sendRedirect("/home");
                        }
                    }else{
                        if(request.getAttribute("referrer") != null){
                            response.sendRedirect("/login?referrer=" + URLEncoder.encode(((String)request.getAttribute("referrer")), "UTF-8"));
                        }else{
                            request.setAttribute("error", "Credenziali errate");
                            response.sendRedirect("/login?error=100");
                        }
                    }

                }else{

                    if(request.getAttribute("referrer") != null){
                        response.sendRedirect("/login?referrer=" + URLEncoder.encode(((String)request.getAttribute("referrer")), "UTF-8"));
                    }else{
                        response.sendRedirect("/login&error=102");
                    }
                }
            }catch (DataException ex) {
                //TODO Handle Exception

            }
        } else {

            if(request.getAttribute("referrer") != null){
                response.sendRedirect("/login?referrer=" + URLEncoder.encode(((String)request.getAttribute("referrer")), "UTF-8"));
            }else{
                response.sendRedirect("/login?error=101");
            }
        }
    }
}
