package com.company.pollweb.controllers.domande;

import com.company.pollweb.controllers.PollWebBaseController;
import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.models.Domanda;
import com.company.pollweb.data.models.Utente;
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

import static com.company.pollweb.framework.security.SecurityLayer.checkSession;

public class MostraModificaDomanda extends PollWebBaseController {
    @Override
    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException, TemplateManagerException, DataException, SQLException {
        try {
            HttpSession s = checkSession(request);
            if (s!= null) {
                action_modifica(request, response, s);
            } else {
                action_redirect(request, response);
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    private void action_modifica(HttpServletRequest request, HttpServletResponse response, HttpSession s) throws IOException, ServletException {
        try {
            PollwebDataLayer pd = ((PollwebDataLayer) request.getAttribute("datalayer"));
            Utente currentuser = pd.getUtenteDAO().getUtente((int) s.getAttribute("user_id"));
            if (currentuser.getNomeRuolo().equals("Utente")) {
                request.setAttribute("message", "Non sei autorizzato ad accedere a questa area");
                request.setAttribute("submessage", "Contatta gli amministratori per diventare responsabile");
                action_error(request, response);
            } else {
                int domandaId = Integer.parseInt(request.getParameter("domanda_id"));
                Domanda domanda = pd.getDomandaDAO().getDomandaByID(domandaId);
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("domanda", domanda);
                res.activate("sondaggi/domande/modifica.ftl", request, response);
            }
        } catch (TemplateManagerException | DataException e) {
            e.printStackTrace();
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

    private void action_error(HttpServletRequest request, HttpServletResponse response) {
        if (request.getAttribute("exception") != null) {
            (new FailureResult(getServletContext())).activate((Exception) request.getAttribute("exception"), request, response);
        } else {
            (new FailureResult(getServletContext())).activate((String) request.getAttribute("message"), request, response);
        }
    }
    }

