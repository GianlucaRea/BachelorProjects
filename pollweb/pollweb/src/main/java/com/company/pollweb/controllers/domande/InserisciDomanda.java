package com.company.pollweb.controllers.domande;

import com.company.pollweb.controllers.PollWebBaseController;
import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.models.Domanda;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.FailureResult;
import com.company.pollweb.utility.Serializer;
import org.json.JSONObject;


import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.io.IOException;


import static com.company.pollweb.framework.security.SecurityLayer.checkSession;

public class InserisciDomanda extends PollWebBaseController {

    protected String  pattern, chooses , type;
    protected int max_length, min_length,max_num,min_num,max_chooses,min_chooses,data;
    protected JSONObject Vincoli;

    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException, DataException {
        HttpSession s = checkSession(request);
        if(s != null){
            action_inserisci(request, response, s);
        }else {
            action_redirect(request, response);
        }
    }

    private void action_inserisci(HttpServletRequest request, HttpServletResponse response, HttpSession s)throws IOException {
            try {
                if (request.getParameterMap() != null) {
                    PollwebDataLayer pd = ((PollwebDataLayer) request.getAttribute("datalayer"));
                    pd.init();
                    Domanda d = pd.getDomandaDAO().creazioneDomanda();
                    int sondaggioId = Integer.parseInt(request.getParameter("id"));
                    if (d != null) {
                        d.setSondaggio_id(sondaggioId);
                        d.setTesto(request.getParameter("testo"));
                        d.setNota(request.getParameter("nota"));
                        if (request.getParameter("obbligo") != null){
                            d.setObbligo(1);
                        }else{
                            d.setObbligo(0);
                        }
                        d.setTipologia(request.getParameter("tipologia"));
                        d.setOrdine(pd.getDomandaDAO().prendiOrdine(sondaggioId));
                        type = request.getParameter("tipologia");
                        switch(type) {
                            case "testo_breve":
                                max_length = Integer.parseInt(request.getParameter("LunghezzaMassimaTestoBreve"));
                                pattern = request.getParameter("PatternTestoBreve");
                                if(max_length != 0) {
                                    if(pattern != null && pattern.length() > 0) {
                                        Vincoli = Serializer.testobreveToJSONF(max_length,pattern);
                                    }else{
                                        Vincoli = Serializer.testobreveToJSONNP(max_length);
                                    }
                                }else{
                                    if(pattern != null && pattern.length() > 0) {
                                        Vincoli = Serializer.testobreveToJSONNM(pattern);
                                    }else{
                                        Vincoli = Serializer.ToJSONN();
                                    }
                                }
                                d.setVincoli(Vincoli);
                                break;
                            case "testo_lungo":
                                max_length = Integer.parseInt(request.getParameter("LunghezzaMassimaTestoLungo"));
                                min_length = Integer.parseInt(request.getParameter("LunghezzaMinimaTestoLungo"));
                                pattern = request.getParameter("PatternTestoLungo");
                                if(max_length != 0) {
                                    if(pattern != null && pattern.length() > 0) {
                                        if(min_length != 0) {
                                            Vincoli = Serializer.testolungoToJSONF(min_length, max_length ,pattern);
                                        }else{
                                            Vincoli = Serializer.testolungoToJSONNm(max_length,pattern);
                                        }
                                    }else{
                                        if(min_length != 0) {
                                            Vincoli = Serializer.testolungoToJSONP(max_length, min_length );
                                        }else{
                                            Vincoli = Serializer.testolungoToJSONNPm(max_length);
                                        }
                                    }
                                }else{
                                    if(pattern != null) {
                                        if(min_length != 0) {
                                            Vincoli = Serializer.testolungoToJSONM(min_length ,pattern);
                                        }else{
                                            Vincoli = Serializer.testolungoToJSONNMn(pattern);
                                        }
                                    }else{
                                        if(min_length != 0) {
                                            Vincoli = Serializer.testolungoToJSONNPM(min_length);
                                        }else{
                                            Vincoli = Serializer.ToJSONN();
                                        }
                                    }
                                }
                                d.setVincoli(Vincoli);
                                break;
                            case "numero":
                                max_num = Integer.parseInt(request.getParameter("Numeromassimo"));
                                min_num = Integer.parseInt(request.getParameter("Numerominimo"));
                                if(max_num != -10000) {
                                    if(min_num != -10000) {
                                        Vincoli = Serializer.numeroToJSONF(max_num,min_num);
                                    }else{
                                        Vincoli = Serializer.numeroToJSONm(max_num);
                                    }
                                }else{
                                    if(min_num != -10000) {
                                        Vincoli = Serializer.testobreveToJSONM(min_num);
                                    }else{
                                        Vincoli = Serializer.ToJSONN();
                                    }
                                }

                                d.setVincoli(Vincoli);
                                break;
                            case "data":
                                if(request.getParameter("dataSuccessivaOdierna") != null && request.getParameter("dataSuccessivaOdierna").length() > 0) {
                                    data = Integer.parseInt(request.getParameter("dataSuccessivaOdierna"));
                                    Vincoli = Serializer.dataToJSON(data);
                                    d.setVincoli(Vincoli);
                                }
                                break;
                            case "scelta_singola":
                                chooses = request.getParameter("sceltasingola");
                                Vincoli = Serializer.sceltaSingolaToJSON(chooses);
                                d.setVincoli(Vincoli);
                                break;
                            case "scelta_multipla":
                                chooses = request.getParameter("sceltamultipla");
                                min_chooses = Integer.parseInt(request.getParameter("Numerominimoscelte"));
                                max_chooses = Integer.parseInt(request.getParameter("Numeromassimoscelte"));
                                if(max_chooses != -10000) {
                                    if(min_chooses != 0) {
                                        Vincoli = Serializer.sceltaMultiplaToJSONF(chooses,min_chooses,max_chooses);
                                    }else{
                                        Vincoli = Serializer.sceltaMultiplaToJSONNm(chooses,max_chooses);
                                    }
                                }else{
                                    if(min_chooses != -10000) {
                                        Vincoli = Serializer.sceltaMultiplaToJSONNM(chooses,min_chooses);
                                    }else{
                                        Vincoli = Serializer.sceltaSingolaToJSON(chooses);
                                    }
                                }
                                d.setVincoli(Vincoli);
                                break;
                        }
                        pd.getDomandaDAO().salvaDomanda(d);
                    } else {
                        request.setAttribute("message", "Errore creazione Domanda");
                        action_error(request, response);
                    }
                    action_write(request, response, sondaggioId);
                }

            } catch (DataException e) {
                request.setAttribute("message", "Errore creazione del sondaggio");
                action_error(request, response);
            }
        }


    private void action_write(HttpServletRequest request, HttpServletResponse response, int sondaggioId) throws IOException {
        response.sendRedirect("/sondaggi/riepilogo?success=302&id=" + sondaggioId);
    }

    private void action_redirect(HttpServletRequest request, HttpServletResponse response) throws IOException{
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
