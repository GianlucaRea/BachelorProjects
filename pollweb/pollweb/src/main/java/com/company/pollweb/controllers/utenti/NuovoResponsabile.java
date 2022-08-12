package com.company.pollweb.controllers.utenti;

import com.company.pollweb.controllers.PollWebBaseController;
import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.models.Utente;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.SplitSlashesFmkExt;
import com.company.pollweb.framework.result.TemplateManagerException;
import com.company.pollweb.framework.result.TemplateResult;
import org.jasypt.util.password.BasicPasswordEncryptor;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.io.IOException;
import java.sql.SQLException;

import static com.company.pollweb.framework.security.SecurityLayer.checkSession;

public class NuovoResponsabile extends PollWebBaseController {
    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException, DataException {
        try {
            HttpSession s = checkSession(request);

            //TODO check se amministratore o creatore sondaggio
            if (s!= null) {
                if(request.getMethod().equals("POST")) {
                    action_post_method(request, response, s);
                } else {
                    action_get_method(request, response, s);
                }
            } else {
                action_redirect(request, response);
            }
        } catch (IOException | TemplateManagerException e) {
            e.printStackTrace();
        }
    }

    private void action_get_method(HttpServletRequest request, HttpServletResponse response, HttpSession s) throws TemplateManagerException, DataException {
        ((PollwebDataLayer) request.getAttribute("datalayer")).init();
        Utente utente = ((PollwebDataLayer) request.getAttribute("datalayer")).getUtenteDAO().getUtente((int) s.getAttribute("user_id"));

        //controllo sia l'amministratore
        if(utente.getId() == 1) {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            res.activate("utenti/nuovoResponsabile.ftl", request, response);
        } else {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Permesso negato");
            res.activate("/error.ftl", request, response);
        }
    }

    private void action_post_method(HttpServletRequest request, HttpServletResponse response, HttpSession s) throws DataException, TemplateManagerException, IOException {
        Utente utente = ((PollwebDataLayer) request.getAttribute("datalayer")).getUtenteDAO().creaUtente();

        if (utente != null) {
            utente.setNome(request.getParameter("nome"));
            utente.setCognome(request.getParameter("cognome"));
            utente.setEmail(request.getParameter("email"));
            utente.setPassword(new BasicPasswordEncryptor().encryptPassword("password"));
            utente.setRuolo(2);
            ((PollwebDataLayer) request.getAttribute("datalayer")).getUtenteDAO().salvaUtente(utente);
            response.sendRedirect("/home?success=200");
        } else {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Si è verificato un errore");
            res.activate("/error.ftl", request, response);
        }

    }

    private void action_redirect(HttpServletRequest request, HttpServletResponse response) throws  IOException {
        try {
            request.setAttribute("urlrequest", request.getRequestURL());
            RequestDispatcher rd = request.getRequestDispatcher("/login");
            rd.forward(request, response);
        } catch (ServletException e) {
            e.printStackTrace();
        }
    }
}