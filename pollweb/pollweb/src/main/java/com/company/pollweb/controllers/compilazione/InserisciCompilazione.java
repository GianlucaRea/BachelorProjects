package com.company.pollweb.controllers.compilazione;

import com.company.pollweb.controllers.PollWebBaseController;
import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.implementation.CompilazioneImpl;
import com.company.pollweb.data.models.Compilazione;
import com.company.pollweb.data.models.Domanda;
import com.company.pollweb.data.models.Sondaggio;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.SplitSlashesFmkExt;
import com.company.pollweb.framework.result.TemplateManagerException;
import com.company.pollweb.framework.result.TemplateResult;
import com.company.pollweb.utility.ValidazioneCampi;
import org.json.JSONArray;
import org.json.JSONObject;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.sql.SQLException;
import java.util.*;
import java.util.concurrent.atomic.AtomicBoolean;

public class InserisciCompilazione extends PollWebBaseController {
    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException, DataException {
        try {
            if(request.getParameter("sondaggioId") == null) {
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("error", "Sondaggio non trovato");
                res.activate("/error.ftl", request, response);
                return ;
            }

            int sondaggioId = Integer.parseInt(request.getParameter("sondaggioId"));
            ((PollwebDataLayer) request.getAttribute("datalayer")).init();
            Sondaggio sondaggio = ((PollwebDataLayer) request.getAttribute("datalayer")).getSondaggioDAO().getSondaggio(sondaggioId);
            Compilazione compilazione = action_ottieni_compilazione(request,response,sondaggio);
            Map<Integer, JSONArray> risposte = action_crea_map_risposte(request);
            if(compilazione.getId() > 0 && action_valida_compilazione(request,response, sondaggio, risposte)){
                action_inserisci_compilazione(request, response, sondaggio, compilazione, risposte);
            }

        } catch (TemplateManagerException | SQLException e) {
            e.printStackTrace();
        }
    }

    protected Compilazione action_ottieni_compilazione(HttpServletRequest request, HttpServletResponse response, Sondaggio sondaggio) throws DataException, SQLException {
        Compilazione c = new CompilazioneImpl();
        System.out.println("PROVA");
        System.out.println(sondaggio.getVisibilita());
        if(sondaggio.getVisibilita() == 1) {
            //sondaggio pubblico
            System.out.println("ENTRO1");
            c.setSondaggioId(sondaggio.getId());
            ((PollwebDataLayer) request.getAttribute("datalayer")).getCompilazioneDAO().salvaCompilazione(c);
        } else {
            //sondaggio privato
            System.out.println("ENTRO2");
            c = ((PollwebDataLayer) request.getAttribute("datalayer")).getCompilazioneDAO().getCompilazione(sondaggio.getId(), Integer.parseInt(request.getParameter("utente_id"))); //Il probelma ale è qui
        }
        System.out.println("COMPILAZIONE");
        System.out.println(c.getSondaggioId());
        System.out.println(c.getUserId());
        return c;
    }

    protected Map<Integer, JSONArray> action_crea_map_risposte(HttpServletRequest request){
        Map<Integer, JSONArray> risposte = new HashMap<Integer, JSONArray>();
        Enumeration<String> parameterNames = request.getParameterNames();
        while (parameterNames.hasMoreElements()) {
            String paramName = parameterNames.nextElement();
            if(paramName.startsWith("domande[")) {
                String[] paramValues = request.getParameterValues(paramName);
                JSONArray risposta = new JSONArray();
                for (String paramValue : paramValues) {
                    risposta.put(paramValue);
                }
                risposte.put(Integer.valueOf(paramName.replace("domande[","").replace("]", "")), risposta);
            }
        }
        return risposte;
    }

    protected boolean action_valida_compilazione(HttpServletRequest request, HttpServletResponse response, Sondaggio sondaggio, Map<Integer, JSONArray> risposte) throws SQLException, DataException {
        //PRENDI TUTTE LE DOMANDE DAL DB
        ((PollwebDataLayer) request.getAttribute("datalayer")).init();
        List<Domanda> domande = ((PollwebDataLayer) request.getAttribute("datalayer")).getDomandaDAO().getDomandeBySondaggioID(sondaggio.getId());
        AtomicBoolean valido = new AtomicBoolean(true);
        risposte.forEach((domandaId, risposta) -> {
            for(Domanda domanda : domande) {
                if(domandaId == domanda.getId()) {
                    if(!ValidazioneCampi.checkCampoCompilazione(domanda, risposta)) {
                        //SI È VERIFICATO UN ERRORE
                        try {
                            if(valido.get()) {
                                if(sondaggio.getVisibilita() == 2) {
                                    response.sendRedirect("/sondaggi/compilazione?id=" + sondaggio.getId() + "&?error=1&email=" + request.getParameter("email"));
                                    valido.set(false);
                                } else {
                                    response.sendRedirect("/sondaggi/compilazione?id=" + sondaggio.getId() + "&?error=1");
                                    valido.set(false);
                                }
                            }


                        } catch (IOException e) {
                            e.printStackTrace();
                        }
                    }
                }
            }
        });
        return valido.get();
    }

    protected void action_inserisci_compilazione(HttpServletRequest request, HttpServletResponse response, Sondaggio sondaggio, Compilazione c, Map<Integer, JSONArray> risposte) throws DataException, SQLException, TemplateManagerException {
        //inserisci risposte in compilazione
        ((PollwebDataLayer) request.getAttribute("datalayer")).init();
        ((PollwebDataLayer) request.getAttribute("datalayer")).getCompilazioneDAO().salvaCompilazione(c.getId(), risposte);

        TemplateResult res = new TemplateResult(getServletContext());
        request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
        request.setAttribute("sondaggioId", sondaggio.getId());
        res.activate("sondaggi/compilazione/terminata.ftl", request, response);
    }
}
