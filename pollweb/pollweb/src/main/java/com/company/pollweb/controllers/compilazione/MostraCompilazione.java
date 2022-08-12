package com.company.pollweb.controllers.compilazione;

import com.company.pollweb.controllers.PollWebBaseController;
import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.dao.SondaggioDao;
import com.company.pollweb.data.models.Domanda;
import com.company.pollweb.data.models.Sondaggio;
import com.company.pollweb.data.models.Utente;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.SplitSlashesFmkExt;
import com.company.pollweb.framework.result.TemplateManagerException;
import com.company.pollweb.framework.result.TemplateResult;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.sql.SQLException;
import java.util.List;

public class MostraCompilazione extends PollWebBaseController {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException, DataException {
        try {
            if(request.getParameter("id") == null) {
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("error", "Sondaggio non trovato");
                res.activate("/error.ftl", request, response);
                return ;
            }

            int sondaggioId =  Integer.parseInt(request.getParameter("id"));
            SondaggioDao sondaggioDao = ((PollwebDataLayer) request.getAttribute("datalayer")).getSondaggioDAO();
            Sondaggio sondaggio = sondaggioDao.getSondaggio(sondaggioId);


            if(!action_check_is_active(request, response, sondaggio)) return;
            if(action_check_visibility(request, response, sondaggio, sondaggioDao)){
                action_compila_sondaggio(request, response);
            }

        } catch (TemplateManagerException | SQLException e) {
            e.printStackTrace();
        }
    }

    private boolean action_check_is_active(HttpServletRequest request, HttpServletResponse response, Sondaggio sondaggio) throws TemplateManagerException {
        if(sondaggio.getStato() == 0) {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Sondaggio non attivo");
            res.activate("/error.ftl", request, response);
            return false;
        }

        if(sondaggio.getStato() == 2) {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Sondaggio scaduto");
            res.activate("/error.ftl", request, response);
            return false;
        }
        return true;
    }

    private boolean action_check_visibility(HttpServletRequest request, HttpServletResponse response, Sondaggio sondaggio, SondaggioDao sondaggioDao) throws TemplateManagerException, SQLException, DataException {
        if(sondaggio.getId() == -1) {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Questo sondaggio non esiste oppure non è più disponibile");
            res.activate("/error.ftl", request, response);
            return false;
        }
        if(sondaggio.getVisibilita() == 1)  {
            return true;

        } else {


            if(request.getParameter("email") != null) { //utente abilitato alla compilazione
                String email = request.getParameter("email");
                //prendi id dell'utente in base alla compilazione e all'email ed effettua il login
                System.out.println(request.getParameter("password"));
                Utente u = ((PollwebDataLayer) request.getAttribute("datalayer")).getUtenteDAO().getUtentePerCompilazione(request.getParameter("email"), request.getParameter("password"), sondaggio.getId());
                if(u!=null) {
                    if(sondaggioDao.isUtenteAbilitatoAllaCompilazione(sondaggio, u.getId())) {
                        request.setAttribute("utente_id", u.getId());
                        return true;
                    } else {
                        TemplateResult res = new TemplateResult(getServletContext());
                        request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                        request.setAttribute("sondaggioId", sondaggio.getId());
                        request.setAttribute("error", "Questo utente non è abilitato alla compilazione del sondaggio");
                        res.activate("sondaggi/formSondaggioPrivato.ftl", request, response);
                        return false;
                    }
                } else {
                    TemplateResult res = new TemplateResult(getServletContext());
                    request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                    request.setAttribute("sondaggioId", sondaggio.getId());
                    request.setAttribute("error", "Questo utente non è abilitato alla compilazione del sondaggio");
                    res.activate("sondaggi/formSondaggioPrivato.ftl", request, response);
                    return false;
                }


            } else { // altrimenti, rimanda al form di inserimento email per verificare che sia stato invitato
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("sondaggioId", sondaggio.getId());
                res.activate("sondaggi/formSondaggioPrivato.ftl", request, response);
                return false;
            }


        }
    }

    private void action_compila_sondaggio(HttpServletRequest request, HttpServletResponse response) throws DataException, SQLException, TemplateManagerException {
        try {
            //TODO verifica che se il sondaggio è privato, allora solo chi non ha già compilato può compilare
            int sondaggioId = Integer.parseInt(request.getParameter("id"));

            ((PollwebDataLayer) request.getAttribute("datalayer")).init();
            Sondaggio sondaggio = ((PollwebDataLayer) request.getAttribute("datalayer")).getSondaggioDAO().getSondaggio(sondaggioId);
            if (sondaggio != null) {
                request.setAttribute("sondaggio", sondaggio);
                List<Domanda> domande = ((PollwebDataLayer) request.getAttribute("datalayer")).getDomandaDAO().getDomandeBySondaggioID(sondaggioId);
                request.setAttribute("domande", domande);
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                res.activate("sondaggi/compilazione.ftl", request, response);
            } else {
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("error", "Il sondaggio non esiste");
                res.activate("/error.ftl", request, response);
                return ;
            }
        } catch (DataException ex) {
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Non è possibile caricare il sondaggio");
            res.activate("/error.ftl", request, response);
            return ;
        }
    }
}
