package com.company.pollweb.controllers.domande;

import com.company.pollweb.controllers.PollWebBaseController;
import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.models.Domanda;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.SplitSlashesFmkExt;
import com.company.pollweb.framework.result.TemplateManagerException;
import com.company.pollweb.framework.result.TemplateResult;
import org.json.JSONObject;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.io.IOException;
import java.io.PrintWriter;

import static com.company.pollweb.framework.security.SecurityLayer.checkSession;

public class CambiaOrdineDomanda extends PollWebBaseController {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, TemplateManagerException {

        try {
            HttpSession s = checkSession(request);
            if (s!= null) {
                action_update(request, response, s);
            } else {
                action_redirect(request, response);
            }
        } catch (IOException | DataException e) {
            e.printStackTrace();
        }
    }

    private void action_update(HttpServletRequest request, HttpServletResponse response, HttpSession s) throws DataException, TemplateManagerException, IOException {
        try {
            int sondaggioId = Integer.parseInt(request.getParameter("id"));
            int domandaId1 = Integer.parseInt(request.getParameter("domanda_id1"));
            int domandaId2 = Integer.parseInt(request.getParameter("domanda_id2"));
            PollwebDataLayer pd = ((PollwebDataLayer) request.getAttribute("datalayer"));
            Domanda d1 = pd.getDomandaDAO().getDomandaByID(domandaId1);
            Domanda d2 = pd.getDomandaDAO().getDomandaByID(domandaId2);
            if (d1 != null && d2 != null ) {
                if(d1.getSondaggio_id() == d2.getSondaggio_id()) {
                    int d1_ordine = d1.getOrdine();
                    int d2_ordine = d2.getOrdine();
                    pd.getDomandaDAO().UpdateOrdine(d1.getId() , d2_ordine);
                    pd.getDomandaDAO().UpdateOrdine(d2.getId() , d1_ordine);
                    action_write(request,response,sondaggioId);
                } else {
                    PrintWriter out = response.getWriter();
                    response.setContentType("application/json");
                    response.setStatus(500);
                    response.setCharacterEncoding("UTF-8");
                    out.print(new JSONObject().append("success", false).append("message", "Le due domande non appartengono allo stesso sondaggio"));
                    out.flush();
                }

            } else {
                PrintWriter out = response.getWriter();
                response.setContentType("application/json");
                response.setStatus(500);
                response.setCharacterEncoding("UTF-8");
                out.print(new JSONObject().append("success", false).append("message", "Le due domande non esistono"));
                out.flush();
            }
        }catch (IOException e){
            PrintWriter out = response.getWriter();
            response.setContentType("application/json");
            response.setStatus(500);
            response.setCharacterEncoding("UTF-8");
            out.print(new JSONObject().append("success", false));
            out.flush();
        }
    }

    private void action_write(HttpServletRequest request, HttpServletResponse response, int sondaggioId) throws IOException {
        PrintWriter out = response.getWriter();
        response.setContentType("application/json");
        response.setCharacterEncoding("UTF-8");
        out.print(new JSONObject().append("success", true));
        out.flush();
    }


    private void action_redirect(HttpServletRequest request, HttpServletResponse response) throws  IOException {
        response.sendRedirect("/login?error=200");
    }
}
