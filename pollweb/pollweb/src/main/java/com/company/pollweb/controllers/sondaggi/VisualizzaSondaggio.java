package com.company.pollweb.controllers.sondaggi;

import com.company.pollweb.controllers.PollWebBaseController;
import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.dao.SondaggioDao;
import com.company.pollweb.data.models.Sondaggio;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.SplitSlashesFmkExt;
import com.company.pollweb.framework.result.TemplateManagerException;
import com.company.pollweb.framework.result.TemplateResult;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.sql.SQLException;

/**
 *
 * @author alessandrodorazio
 */
public class VisualizzaSondaggio extends PollWebBaseController {
    @Override
    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException, TemplateManagerException, DataException {
        try {
            int sondaggioId =  Integer.parseInt(request.getParameter("id"));
            SondaggioDao sondaggioDao = ((PollwebDataLayer) request.getAttribute("datalayer")).getSondaggioDAO();
            Sondaggio sondaggio = sondaggioDao.getSondaggio(sondaggioId);
            if(sondaggio.getStato() == 0 || sondaggio.getStato() == 2) {
                //verifica se il sondaggio è attivo
                action_check_is_active(request, response, sondaggio);
            } else {
                //verifica se il sondaggio è visibile
                action_check_visibility(request, response, sondaggio, sondaggioDao);
            }
        }catch(Exception e) {
            e.printStackTrace();
        }
    }

    private void action_check_is_active(HttpServletRequest request, HttpServletResponse response, Sondaggio sondaggio) throws TemplateManagerException {
        if(sondaggio != null) {
        if(sondaggio.getStato() == 0) {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Sondaggio non attivo");
            res.activate("/error.ftl", request, response);
            return ;
        }

        if(sondaggio.getStato() == 2) {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Sondaggio scaduto");
            res.activate("/error.ftl", request, response);
            return ;
        }
    } else {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Il sondaggio non esiste");
            res.activate("/error.ftl", request, response);
        }
    }

    private void action_check_visibility(HttpServletRequest request, HttpServletResponse response, Sondaggio sondaggio, SondaggioDao sondaggioDao) throws TemplateManagerException, SQLException {
        if(sondaggio != null){
        if(sondaggio.getId() == -1) {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Questo sondaggio non esiste oppure non è più disponibile");
            res.activate("/error.ftl", request, response);
            return ;
        }
        if(sondaggio.getVisibilita() == 1)  {
            System.out.println("SONDAGGIO VISIBILE");
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            res.activate("sondaggi/compilazione.ftl", request, response);
        } else {
            // verifica se è stata inserita l'email e l'utente può accedervi
            int utente_id = Integer.parseInt(request.getParameter("utente_id"));
            //TODO controllo se email rispetta il pattern
            if(utente_id > 0 && sondaggioDao.isUtenteAbilitatoAllaCompilazione(sondaggio, utente_id)) { //email abilitata alla compilazione
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                res.activate("sondaggi/compilazione.ftl", request, response);
            } else { // altrimenti, rimanda al form di inserimento email per verificare che sia stato invitato
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("sondaggioId", sondaggio.getId());
                request.setAttribute("error", "Questa email non è abilitata alla compilazione del sondaggio");
                res.activate("sondaggi/formSondaggioPrivato.ftl", request, response);
            }


        }
    } else {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Il sondaggio non esiste");
            res.activate("/error.ftl", request, response);
        }
    }
}
