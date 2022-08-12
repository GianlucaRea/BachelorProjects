package com.company.pollweb.controllers.compilazione;

import com.company.pollweb.controllers.PollWebBaseController;
import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.models.Domanda;
import com.company.pollweb.data.models.Sondaggio;
import com.company.pollweb.data.models.Utente;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.SplitSlashesFmkExt;
import com.company.pollweb.framework.result.TemplateManagerException;
import com.company.pollweb.framework.result.TemplateResult;
import com.company.pollweb.utility.GeneratoreCSV;
import com.company.pollweb.utility.Pair;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.io.IOException;
import java.io.OutputStream;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import static com.company.pollweb.framework.security.SecurityLayer.checkSession;

/**
 * @author gianlucarea
 */
public class EsportaCompilazione extends PollWebBaseController {
    @Override
    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws TemplateManagerException, DataException, SQLException, IOException {
        HttpSession s = checkSession(request);
        if (s != null && request.getParameter("id") != null) {
            action_esporta(request, response, s);
        } else {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Permesso negato");
            res.activate("/error.ftl", request, response);
        }
    }

    private void action_esporta(HttpServletRequest request, HttpServletResponse response, HttpSession s) throws DataException, SQLException, IOException, TemplateManagerException {
        try {
            int sondaggioId = Integer.parseInt(request.getParameter("id"));
            Utente utente = ((PollwebDataLayer) request.getAttribute("datalayer")).getUtenteDAO().getUtente((int) s.getAttribute("user_id"));
            Sondaggio sondaggio = ((PollwebDataLayer) request.getAttribute("datalayer")).getSondaggioDAO().getSondaggio(sondaggioId);
            List<Domanda> domande = ((PollwebDataLayer) request.getAttribute("datalayer")).getDomandaDAO().getDomandeBySondaggioID(sondaggio.getId());
            if (utente != null && sondaggio != null && domande != null && utente.getId() == sondaggio.getUtenteId()) {
                if (sondaggio.getVisibilita() == 1){
                    // Creazione di una lista di lista di stringhe: domanda, risposta
                    List<List<String>> risultati = new ArrayList<List<String>>();
                for (Domanda d : domande) {
                    List<String> rList = ((PollwebDataLayer) request.getAttribute("datalayer")).getCompilazioneDAO().getRisposteByDomandaId(d.getId());
                    for (String r : rList) {
                        List<String> Stringrispota = new ArrayList<>();
                        Stringrispota.add(d.getTesto());
                        Stringrispota.add(r);
                        risultati.add(Stringrispota);
                    }
                }

                if (!risultati.isEmpty()) {
                    response.setContentType("text/csv");
                    response.setHeader("Content-Disposition", "attachment; filename=\"" + sondaggio.getTitolo() + ".csv\"");
                    OutputStream outputStream = response.getOutputStream();
                    String outputResult = GeneratoreCSV.nuovaStringaCSV(risultati);
                    outputStream.write(outputResult.getBytes());
                    outputStream.flush();
                    outputStream.close();
                    action_write(request, response);
                } else {
                    TemplateResult res = new TemplateResult(getServletContext());
                    request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                    request.setAttribute("error", "Il csv non è esportato per mancanze di domande");
                    res.activate("/error.ftl", request, response);
                }
            }else{
                    List<List<String>> risultati = new ArrayList<List<String>>();
                    for (Domanda d : domande) {
                        ArrayList<Pair>  eList = ((PollwebDataLayer) request.getAttribute("datalayer")).getCompilazioneDAO().getEmailByDomandaId(d.getId());
                        for (Pair r : eList) {
                            List<String> Stringrispota = new ArrayList<>();
                            Utente utenteEmail = ((PollwebDataLayer) request.getAttribute("datalayer")).getUtenteDAO().getUtente(r.getL());
                            String email = utenteEmail.getEmail();
                            Stringrispota.add(email);
                            Stringrispota.add(d.getTesto());
                            Stringrispota.add(r.getR());
                            risultati.add(Stringrispota);
                        }
                    }
                    if (!risultati.isEmpty()) {
                        response.setContentType("text/csv");
                        response.setHeader("Content-Disposition", "attachment; filename=\"" + sondaggio.getTitolo() + ".csv\"");
                        OutputStream outputStream = response.getOutputStream();
                        String outputResult = GeneratoreCSV.nuovaStringaPrivatoCSV(risultati);
                        outputStream.write(outputResult.getBytes());
                        outputStream.flush();
                        outputStream.close();
                        action_write(request, response);
                    } else {
                        TemplateResult res = new TemplateResult(getServletContext());
                        request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                        request.setAttribute("error", "Il csv non è esportato per mancanze di domande");
                        res.activate("/error.ftl", request, response);
                    }
            }
            } else {
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("error", "Permesso negato");
                res.activate("/error.ftl", request, response);
        }
        } catch (DataException e) {
            e.printStackTrace();
        }
    }

    private void action_write(HttpServletRequest request, HttpServletResponse response) throws  IOException {
        response.sendRedirect("/home?success=102");
    }
}
