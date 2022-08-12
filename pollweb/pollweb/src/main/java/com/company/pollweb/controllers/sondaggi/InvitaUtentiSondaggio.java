package com.company.pollweb.controllers.sondaggi;

import com.company.pollweb.controllers.PollWebBaseController;
import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.models.Utente;
import com.company.pollweb.framework.data.DataException;
import org.jasypt.util.password.BasicPasswordEncryptor;

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
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.stream.Collectors;

import static com.company.pollweb.framework.security.SecurityLayer.checkSession;

public class InvitaUtentiSondaggio extends PollWebBaseController {
    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException, DataException {

        try {
            HttpSession s = checkSession(request);
            int sondaggioId = Integer.parseInt(request.getParameter("id"));
            if (s!= null) {
                action_invite(request, response, s, sondaggioId);
            } else {
                action_redirect(request, response);
            }
        } catch (IOException | SQLException e) {
            e.printStackTrace();
        }
    }

    private void action_invite(HttpServletRequest request, HttpServletResponse response, HttpSession s, int sondaggioId) throws SQLException, IOException, ServletException, DataException {

        List<Utente> utenti = new ArrayList<Utente>();
        Utente u;
        for(int i = 1 ;request.getParameter("nuovoInvitato["+i+"][nome]") != null ; i++){

            ((PollwebDataLayer) request.getAttribute("datalayer")).init();
            u = ((PollwebDataLayer) request.getAttribute("datalayer")).getUtenteDAO().creaUtente();
            u.setEmail(request.getParameter("nuovoInvitato["+i+"][email]"));
            u.setNome(request.getParameter("nuovoInvitato["+i+"][nome]"));
            u.setPassword(request.getParameter("nuovoInvitato["+i+"][password]"));
            u.setCognome("");
            u.setRuolo(1);
            ((PollwebDataLayer) request.getAttribute("datalayer")).init();
            ((PollwebDataLayer) request.getAttribute("datalayer")).getUtenteDAO().salvaUtente(u);
            utenti.add(u);
        }

        //input da file
        Part csvPart = request.getPart("invitatiCSV");
        InputStream csv = csvPart.getInputStream();
        BufferedReader br = new BufferedReader(new InputStreamReader(csv));
        List<String> utentiPerRiga = br.lines().collect(Collectors.toList());
        for(String utentePerRiga: utentiPerRiga) {
            String[] datiUtente = utentePerRiga.split(";");
            if(!datiUtente[1].equals("") && datiUtente[1] != null) {
                ((PollwebDataLayer) request.getAttribute("datalayer")).init();
                u = ((PollwebDataLayer) request.getAttribute("datalayer")).getUtenteDAO().creaUtente();

                u.setNome(datiUtente[0]);
                u.setEmail(datiUtente[1]);
                u.setPassword(datiUtente[2]);
                u.setCognome("");
                u.setRuolo(1);

                ((PollwebDataLayer) request.getAttribute("datalayer")).init();
                ((PollwebDataLayer) request.getAttribute("datalayer")).getUtenteDAO().salvaUtente(u);
                utenti.add(u);
            }


        }

        if(utenti.size() > 0) {
            ((PollwebDataLayer) request.getAttribute("datalayer")).init();
            ((PollwebDataLayer) request.getAttribute("datalayer")).getSondaggioDAO().invitaUtenti(sondaggioId, utenti);
        }

        int nuovaVisibilita = Integer.parseInt(request.getParameter("visibilitaSondaggio"));
        ((PollwebDataLayer) request.getAttribute("datalayer")).init();
        ((PollwebDataLayer) request.getAttribute("datalayer")).getSondaggioDAO().modificaVisibilita(sondaggioId, nuovaVisibilita);

        response.sendRedirect("/sondaggi/riepilogo?id=" + sondaggioId + "&success=1");
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
