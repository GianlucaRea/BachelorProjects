package com.company.pollweb.controllers.utenti;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


        import java.io.IOException;
        import javax.servlet.ServletException;
        import javax.servlet.http.HttpServletRequest;
        import javax.servlet.http.HttpServletResponse;

        import com.company.pollweb.controllers.PollWebBaseController;
        import com.company.pollweb.framework.security.SecurityLayer;

public class Logout extends PollWebBaseController {

    private void action_logout(HttpServletRequest request, HttpServletResponse response) throws IOException {
        SecurityLayer.disposeSession(request);
        response.sendRedirect("/login");
    }


    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     */
    @Override
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException {
        try {
            action_logout(request, response);
        } catch (IOException ex) {
        }
    }
}