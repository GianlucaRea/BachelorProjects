package com.company.pollweb.controllers;

import com.company.pollweb.data.dao.PollwebDataLayer;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.result.FailureResult;
import com.company.pollweb.framework.result.TemplateManagerException;

import javax.annotation.Resource;
import javax.servlet.ServletException;

import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.sql.DataSource;
import java.io.IOException;
import java.sql.SQLException;

public abstract class PollWebBaseController extends HttpServlet {

    @Resource(name = "jdbc/pollweb")
    private DataSource ds;

    protected abstract void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException, TemplateManagerException, DataException, SQLException;

    private void processBaseRequest(HttpServletRequest request, HttpServletResponse response) {
        try (PollwebDataLayer datalayer = new PollwebDataLayer(ds)) {
            datalayer.init();
            request.setAttribute("datalayer", datalayer);
            request.setCharacterEncoding("UTF-8");
            processRequest(request, response);
        } catch (Exception ex) {
            ex.printStackTrace();
            request.setAttribute("message", "Errore interno");
            request.setAttribute("submessage", "Riprova più tardi");
            action_error(request, response);
        }
    }
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        processBaseRequest(request, response);
    }

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        processBaseRequest(request, response);
    }

    private void action_error(HttpServletRequest request, HttpServletResponse response) {
        if (request.getAttribute("exception") != null) {
            (new FailureResult(getServletContext())).activate((Exception) request.getAttribute("exception"), request, response);
        } else {
            (new FailureResult(getServletContext())).activate((String) request.getAttribute("message"), request, response);
        }
    }


}