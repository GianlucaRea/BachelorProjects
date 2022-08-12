/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.company.pollweb.utility;

import java.io.IOException;
import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

/**
 *
 * @author alessandrodorazio
 */
public class FiltroAutenticazione {
    
    public static boolean checkLoggato(HttpServletRequest in) {
        HttpSession session= in.getSession(false); 
        if(session == null || session.getAttribute("email") == null) {
            return false;
        }
        
        return true;
    }
    
    public static void soloLoggati(HttpServletRequest in, HttpServletResponse out) throws ServletException, IOException {
        //controllo se l'utente è loggato
        HttpSession session=in.getSession(false);  
        
        if(session == null || session.getAttribute("email") == null) {
            out.setContentType("text/html;charset=UTF-8");
            RequestDispatcher dispatcher = in.getRequestDispatcher("/error.ftl");
            in.setAttribute("error", "Non sei autorizzato ad accedere a questa pagina");
            out.setStatus(403);
            dispatcher.forward(in, out);
            return ;
        }
        
    }
    
  /* public static void soloAdmin(HttpServletRequest in, HttpServletResponse out) throws ServletException, IOException{
        //controllo se l'utente loggato è amministratore
        HttpSession session=in.getSession(false); 
        String emailUtenteLoggato=(String)session.getAttribute("email");
        try {
            if(emailUtenteLoggato == null || UtenteDao.isAdmin(emailUtenteLoggato) == false) {
                out.setContentType("text/html;charset=UTF-8");
                RequestDispatcher dispatcher = in.getRequestDispatcher("/error.ftl");
                in.setAttribute("error", "Non sei autorizzato ad accedere a questa pagina");
                dispatcher.forward(in, out);
                return ;
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(NuovoResponsabile.class.getName()).log(Level.SEVERE, null, ex);
        } catch (SQLException ex) {
            Logger.getLogger(NuovoResponsabile.class.getName()).log(Level.SEVERE, null, ex);
        }
    } */
}
