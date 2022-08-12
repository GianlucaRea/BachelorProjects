package com.company.pollweb.controllers;

import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.models.Utente;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.FailureResult;
import com.company.pollweb.framework.result.SplitSlashesFmkExt;
import com.company.pollweb.framework.result.TemplateManagerException;
import com.company.pollweb.framework.result.TemplateResult;


import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import java.io.IOException;

import static com.company.pollweb.framework.security.SecurityLayer.checkSession;

/**
 *
 * @author gianlucarea
 */

public class CreazioneSondaggio extends PollWebBaseController {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, TemplateManagerException {

        try {
            HttpSession s = checkSession(request);
            if (s!= null) {
                action_poll(request, response, s);
            } else {
                action_redirect(request, response);
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }


    private void action_poll(HttpServletRequest request, HttpServletResponse response, HttpSession s) throws IOException, ServletException {
        try {
            Utente currentuser = ((PollwebDataLayer) request.getAttribute("datalayer")).getUtenteDAO().getUtente((int) s.getAttribute("user_id"));
            if (currentuser.getNomeRuolo().equals("Utente")) {
                request.setAttribute("message", "Non sei autorizzato ad accedere a questa area");
                request.setAttribute("submessage", "Contatta gli amministratori per diventare responsabile");
                action_error(request, response);
            } else {
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                res.activate("sondaggi/creazione.ftl", request, response);
            }
        } catch (TemplateManagerException | DataException e) {
            e.printStackTrace();
        }
    }

    private void action_redirect(HttpServletRequest request, HttpServletResponse response) throws  IOException {
        response.sendRedirect("/login?error=200");
    }

    private void action_error(HttpServletRequest request, HttpServletResponse response) {
        if (request.getAttribute("exception") != null) {
            (new FailureResult(getServletContext())).activate((Exception) request.getAttribute("exception"), request, response);
        } else {
            (new FailureResult(getServletContext())).activate((String) request.getAttribute("message"), request, response);
        }
    }

}
