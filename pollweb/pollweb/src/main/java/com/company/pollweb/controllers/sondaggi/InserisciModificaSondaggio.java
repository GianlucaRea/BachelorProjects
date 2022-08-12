package com.company.pollweb.controllers.sondaggi;

import com.company.pollweb.controllers.PollWebBaseController;
import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.models.Domanda;
import com.company.pollweb.data.models.Sondaggio;
import com.company.pollweb.data.models.Utente;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.SplitSlashesFmkExt;
import com.company.pollweb.framework.result.TemplateManagerException;
import com.company.pollweb.framework.result.TemplateResult;
import com.company.pollweb.utility.Serializer;
import org.jasypt.util.password.BasicPasswordEncryptor;
import org.json.JSONObject;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import javax.servlet.http.Part;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.sql.Array;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Enumeration;
import java.util.List;
import java.util.stream.Collectors;

import static com.company.pollweb.framework.security.SecurityLayer.checkSession;

public class InserisciModificaSondaggio extends PollWebBaseController {

    protected String  pattern, chooses;
    protected int max_length, min_length,max_num,min_num,max_chooses,min_chooses,data;
    protected JSONObject Vincoli;

    @Override
    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws TemplateManagerException {

        try {
            HttpSession s = checkSession(request);
            if (s!= null) {
                action_modifica_sondaggio(request, response, s);
            } else {
                action_redirect(request, response);
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    private void action_modifica_sondaggio(HttpServletRequest request, HttpServletResponse response, HttpSession s) throws TemplateManagerException {
        try {
            if (request.getParameterMap() != null) {

                int sondaggioId = Integer.parseInt(request.getParameter("id"));
                PollwebDataLayer pd = ((PollwebDataLayer) request.getAttribute("datalayer"));
                Sondaggio p = pd.getSondaggioDAO().getSondaggio(sondaggioId);
                Utente user = pd.getUtenteDAO().getUtente((int) s.getAttribute("user_id"));
                if (p != null) {
                    if(request.getParameter("titolo") != null) {
                        p.setTitolo(request.getParameter("titolo"));
                    }
                    if(request.getParameter("testoiniziale") != null) {
                        p.setTestoiniziale(request.getParameter("testoiniziale"));
                    }
                    if(request.getParameter("testofinale") != null) {
                        p.setTestofinale(request.getParameter("testofinale"));
                    }
                    pd.getSondaggioDAO().salvaSondaggio(p);
                }else {
                    TemplateResult res = new TemplateResult(getServletContext());
                    request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                    request.setAttribute("error", "Il sondaggio non esiste");
                    res.activate("/error.ftl", request, response);
                }
                action_write(request, response, p.getId());
            }

        } catch (DataException | SQLException | TemplateManagerException | IOException e) {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Errore Modifica Sondaggio");
            res.activate("/error.ftl", request, response);
        }
    }

    private void action_write(HttpServletRequest request, HttpServletResponse response, int sondaggioId) throws IOException {
        response.sendRedirect("/sondaggi/riepilogo?success=301&id=" + sondaggioId);
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
