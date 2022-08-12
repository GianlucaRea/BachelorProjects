package com.company.pollweb.controllers.domande;

import com.company.pollweb.controllers.PollWebBaseController;
import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.data.models.Domanda;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.SplitSlashesFmkExt;
import com.company.pollweb.framework.result.TemplateManagerException;
import com.company.pollweb.framework.result.TemplateResult;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.io.IOException;

import static com.company.pollweb.framework.security.SecurityLayer.checkSession;

public class EliminaDomanda extends PollWebBaseController {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, TemplateManagerException {

        try {
            HttpSession s = checkSession(request);
            if (s!= null) {
                action_elimina(request, response, s);
            } else {
                action_redirect(request, response);
            }
        } catch (IOException | DataException e) {
            e.printStackTrace();
        }
    }

    private void action_elimina(HttpServletRequest request, HttpServletResponse response, HttpSession s) throws DataException, TemplateManagerException {
        try {
            int sondaggioId = Integer.parseInt(request.getParameter("id"));
            int domandaId = Integer.parseInt(request.getParameter("domanda_id"));
            PollwebDataLayer pd = ((PollwebDataLayer) request.getAttribute("datalayer"));
            Domanda d = pd.getDomandaDAO().getDomandaByID(domandaId);
            if (d != null) {
                pd.getDomandaDAO().eliminaDomanda(domandaId);
                action_write(request,response,sondaggioId);
            } else {
                TemplateResult res = new TemplateResult(getServletContext());
                request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
                request.setAttribute("error", "La domanda non esiste");
                res.activate("/error.ftl", request, response);
            }
        }catch (TemplateManagerException | IOException e){
            TemplateResult res = new TemplateResult(getServletContext());
            request.setAttribute("strip_slashes", new SplitSlashesFmkExt());
            request.setAttribute("error", "Errore Modifica Sondaggio");
            res.activate("/error.ftl", request, response);
        }
    }

    private void action_write(HttpServletRequest request, HttpServletResponse response, int sondaggioId) throws IOException {
        response.sendRedirect("/sondaggi/riepilogo?success=300&id=" + sondaggioId);
    }


    private void action_redirect(HttpServletRequest request, HttpServletResponse response) throws  IOException {
        response.sendRedirect("/login?error=200");
    }
}
