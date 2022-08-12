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
import com.company.pollweb.utility.Mailer;

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
public class PubblicaSondaggio extends PollWebBaseController {
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

            if (s!= null) {
                action_pubblica_sondaggio(request, response, s);
            } else {
                action_redirect(request, response);
            }
        } catch (IOException | TemplateManagerException | SQLException e) {
            e.printStackTrace();
        }
    }

    private void action_pubblica_sondaggio(HttpServletRequest request, HttpServletResponse response, HttpSession s) throws DataException, SQLException, TemplateManagerException, IOException {
        int sondaggioId = Integer.parseInt(request.getParameter("id"));
        ((PollwebDataLayer) request.getAttribute("datalayer")).init();
        Utente utente = ((PollwebDataLayer) request.getAttribute("datalayer")).getUtenteDAO().getUtente((int) s.getAttribute("user_id"));
        ((PollwebDataLayer) request.getAttribute("datalayer")).init();
        Sondaggio sondaggio = ((PollwebDataLayer) request.getAttribute("datalayer")).getSondaggioDAO().getSondaggio(sondaggioId);
        if (sondaggio != null) {
            if (sondaggio.getStato() == 1) {
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("error", "Il sondaggio è già pubblico");
                res.activate("/error.ftl", request, response);
                return;
            }

            if (sondaggio.getStato() == 2) {
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("error", "Il sondaggio è chiuso, non può essere pubblicato nuovamente");
                res.activate("/error.ftl", request, response);
                return;
            }

            if (sondaggio.getUtenteId() == utente.getId() || utente.getId() == 1) {
                String url = "http://localhost:8080/sondaggi/compilazione?id=" + sondaggio.getId();
                List<Utente> invitati = ((PollwebDataLayer) request.getAttribute("datalayer")).getCompilazioneDAO().getUserList(sondaggio.getId());
                for(Utente invitato: invitati) {
                    Mailer.invitaUtenti(invitato.getEmail(), invitato.getPassword(), url);
                }
                ((PollwebDataLayer) request.getAttribute("datalayer")).init();
                ((PollwebDataLayer) request.getAttribute("datalayer")).getSondaggioDAO().pubblicaSondaggio(sondaggio.getId());
                response.sendRedirect("/home?success=100");
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
            RequestDispatcher rd = request.getRequestDispatcher("/login");
            rd.forward(request, response);
        } catch (ServletException e) {
            e.printStackTrace();
        }
    }
}
