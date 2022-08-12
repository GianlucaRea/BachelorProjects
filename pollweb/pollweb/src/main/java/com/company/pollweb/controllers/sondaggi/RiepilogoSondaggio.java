package com.company.pollweb.controllers.sondaggi;

import com.company.pollweb.controllers.PollWebBaseController;
import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.models.Domanda;
import com.company.pollweb.data.models.Utente;
import com.company.pollweb.data.models.Sondaggio;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.FailureResult;
import com.company.pollweb.framework.result.SplitSlashesFmkExt;
import com.company.pollweb.framework.result.TemplateManagerException;
import com.company.pollweb.framework.result.TemplateResult;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import java.io.IOException;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Enumeration;
import java.util.List;

import static com.company.pollweb.framework.security.SecurityLayer.checkSession;

public class RiepilogoSondaggio extends PollWebBaseController {
    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException, DataException {

        try {
            HttpSession s = checkSession(request);

            if(request.getParameter("id") == null) {
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("error", "Sondaggio non trovato");
                res.activate("/error.ftl", request, response);
                return ;
            }
            //TODO check se amministratore o creatore sondaggio
            if (s!= null) {
                action_check_permission(request, response, s);
            } else {
                action_redirect(request, response);
            }
        } catch (IOException | SQLException | TemplateManagerException e) {
            e.printStackTrace();
        }
    }

    private void action_check_permission(HttpServletRequest request, HttpServletResponse response, HttpSession s) throws DataException, SQLException, TemplateManagerException {
        int sondaggioId = Integer.parseInt(request.getParameter("id"));
        ((PollwebDataLayer) request.getAttribute("datalayer")).init();
        Utente utente = ((PollwebDataLayer) request.getAttribute("datalayer")).getUtenteDAO().getUtente((int) s.getAttribute("user_id"));
        ((PollwebDataLayer) request.getAttribute("datalayer")).init();
        Sondaggio sondaggio = ((PollwebDataLayer) request.getAttribute("datalayer")).getSondaggioDAO().getSondaggio(sondaggioId);
        List invitati = ((PollwebDataLayer) request.getAttribute("datalayer")).getCompilazioneDAO().getUserList(sondaggioId);
        if(sondaggio != null){
            if(sondaggio.getUtenteId() == utente.getId() || utente.getId() == 1) {
                ((PollwebDataLayer) request.getAttribute("datalayer")).init();
                ArrayList<Domanda> domande = ((PollwebDataLayer) request.getAttribute("datalayer")).getSondaggioDAO().getDomande(sondaggio.getId());
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("sondaggio", sondaggio);
                request.setAttribute("domande", domande);
                if(invitati.size() != 0){
                    request.setAttribute("invitati",invitati);
                }

                if (request.getParameter("success") != null) {
                    String successMessage = "Operazione completata";
                    switch (request.getParameter("success")) {
                        case "300":
                            successMessage = "Domanda eliminata";
                            break;
                        case "301":
                            successMessage = "Domanda modificata";
                            break;
                        case "302":
                            successMessage = "Domanda inserita";
                            break;
                    }
                    request.setAttribute("success", successMessage);
                }
                if(request.getParameter("error") != null) {
                    request.setAttribute("error", "Si è verificato un errore");
                }
                res.activate("sondaggi/riepilogo.ftl", request, response);
            } else {
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("error", "Permesso negato");
                res.activate("/error.ftl", request, response);
            }
        } else {
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("error", "Il sondaggio non esiste");
                res.activate("/error.ftl", request, response);
            }
    }

    private void action_redirect(HttpServletRequest request, HttpServletResponse response) throws  IOException {
        try {
            request.setAttribute("urlrequest", request.getRequestURL());
            RequestDispatcher rd = request.getRequestDispatcher("/login?error=200");
            rd.forward(request, response);
        } catch (ServletException e) {
            e.printStackTrace();
        }
    }

}
