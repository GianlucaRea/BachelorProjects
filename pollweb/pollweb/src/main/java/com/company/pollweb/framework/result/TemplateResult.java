package com.company.pollweb.framework.result;

import freemarker.core.HTMLOutputFormat;
import freemarker.core.JSONOutputFormat;
import freemarker.core.XMLOutputFormat;
import freemarker.template.Configuration;
import freemarker.template.DefaultObjectWrapperBuilder;
import freemarker.template.Template;
import freemarker.template.TemplateDateModel;
import freemarker.template.TemplateException;
import freemarker.template.TemplateExceptionHandler;
import java.io.IOException;
import java.io.PrintWriter;
import java.io.Writer;
import java.util.Calendar;
import java.util.Enumeration;
import java.util.HashMap;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.servlet.ServletContext;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

/**
 *
 * @author Giuseppe Della Penna
 */
public class TemplateResult {

    protected ServletContext context;
    protected Configuration cfg;
    protected DataModelFiller filler;

    public TemplateResult(ServletContext context) {
        this.context = context;
        init();
    }

    /*
    Impostiamo l'encoding di default [Input/Output] recuperando le informazioni da web.xml "context.getInitiParameter"
    la directory che contiene i template sempre dal context in web.xml
    Se nel context in web.xml � impostata a true "view-debug" mostriamo anche i log degli errori direttamente nel template
    Impostiamo anche lo standard del formato per data e ora nel case del nostro file xml = dd/MM/yyyy hh:mm:ss standar "12/12/1997 13:43:00"
    */
    private void init() {
        cfg = new Configuration(Configuration.VERSION_2_3_26);
        if (context.getInitParameter("view.encoding") != null) {
            cfg.setOutputEncoding(context.getInitParameter("view.encoding"));
            cfg.setDefaultEncoding(context.getInitParameter("view.encoding"));
        }
        if (context.getInitParameter("view.template_directory") != null) {
            cfg.setServletContextForTemplateLoading(context, context.getInitParameter("view.template_directory"));
        } else {
            cfg.setServletContextForTemplateLoading(context, "templates");
        }
        if (context.getInitParameter("view.debug") != null && context.getInitParameter("view.debug").equals("true")) {
            cfg.setTemplateExceptionHandler(TemplateExceptionHandler.HTML_DEBUG_HANDLER);
        } else {
            cfg.setTemplateExceptionHandler(TemplateExceptionHandler.IGNORE_HANDLER);
        }
        if (context.getInitParameter("view.date_format") != null) {
            cfg.setDateTimeFormat(context.getInitParameter("view.date_format"));
        }

        //classe opzionale che permette di riempire ogni data model con dati generati dinamicamente
        filler = null;
        if (context.getInitParameter("view.model_filler") != null) {
            try {
                filler = (DataModelFiller) Class.forName(context.getInitParameter("view.model_filler")).newInstance();
            } catch (ClassNotFoundException ex) {
                Logger.getLogger(TemplateResult.class.getName()).log(Level.SEVERE, null, ex);
            } catch (InstantiationException ex) {
                Logger.getLogger(TemplateResult.class.getName()).log(Level.SEVERE, null, ex);
            } catch (IllegalAccessException ex) {
                Logger.getLogger(TemplateResult.class.getName()).log(Level.SEVERE, null, ex);
            }
        }

        //Impostiamo il gestore degli oggetti
        DefaultObjectWrapperBuilder owb = new DefaultObjectWrapperBuilder(Configuration.VERSION_2_3_26);
        owb.setForceLegacyNonListCollections(false);
        owb.setDefaultDateType(TemplateDateModel.DATETIME);
        cfg.setObjectWrapper(owb.build());
    }

    //questo metodo restituisce un data model (hash) di base,
    //ad esempio strutture fisse presenti nella view come menu ecc...
    //(qui inizializzato anche con informazioni di base utili alla gestione dell'outline)
    protected Map getDefaultDataModel() {
        Map default_data_model = new HashMap();

        if (filler != null) {
            filler.fillDataModel(default_data_model);
        }

        //iniettiamo alcuni dati di default nel data model
        default_data_model.put("compiled_on", Calendar.getInstance().getTime()); //data di compilazione del template
        default_data_model.put("outline_tpl", context.getInitParameter("view.outline_template")); //eventuale template di outline

        //aggiungiamo altri dati di inizializzazione presi dal web.xml
        //add other data taken from web.xml
        Map init_tpl_data = new HashMap();
        default_data_model.put("defaults", init_tpl_data);
        Enumeration parms = context.getInitParameterNames();
        while (parms.hasMoreElements()) {
            String name = (String) parms.nextElement();
            if (name.startsWith("view.data.")) {
                init_tpl_data.put(name.substring(10), context.getInitParameter(name));
            }
        }

        return default_data_model;
    }

    //return a datamodel "HashMap" with the value pass in the request (Object, List taken from the DB)
    protected Map getRequestDataModel(HttpServletRequest request) {
        Map datamodel = new HashMap();
        Enumeration attrs = request.getAttributeNames();
        while (attrs.hasMoreElements()) {
            String attrname = (String) attrs.nextElement();
            datamodel.put(attrname, request.getAttribute(attrname));
        }
        return datamodel;
    }

    //Use for initi the template. Se viene specificata una view questa viene inserita nel template di outline [Include]
    //Se non viene specificato un tempplate di outline, allora viene caricato uno di default
    protected void process(String tplname, Map datamodel, Writer out) throws TemplateManagerException {
        Template t;
        //default map data model - Menu ecc
        Map<String, Object> localdatamodel = getDefaultDataModel();
        if (datamodel != null) {
            localdatamodel.putAll(datamodel);
        }
        String outline_name = (String) localdatamodel.get("outline_tpl");
        try {
            if (outline_name == null || outline_name.isEmpty()) {
                t = cfg.getTemplate(tplname);
            } else {
                t = cfg.getTemplate(outline_name);
                localdatamodel.put("content_tpl", tplname);
            }
            t.process(localdatamodel, out); //Output - Return view
        } catch (IOException e) {
            throw new TemplateManagerException("Template error: " + e.getMessage(), e);
        } catch (TemplateException e) {
            throw new TemplateManagerException("Template error: " + e.getMessage(), e);
        }
    }

    //Active utilizzato quando si esprime un ContentType specifico di ritorno. Json/text-html/xml
    public void activate(String tplname, Map datamodel, HttpServletResponse response) throws TemplateManagerException {

        String contentType = (String) datamodel.get("contentType");
        if (contentType == null) {
            contentType = "text/html";
        }
        response.setContentType(contentType);
        switch (contentType) {
            case "text/html":
                cfg.setOutputFormat(HTMLOutputFormat.INSTANCE);
                break;
            case "text/xml":
            case "application/xml":
                cfg.setOutputFormat(XMLOutputFormat.INSTANCE);
                break;
            case "application/json":
                cfg.setOutputFormat(JSONOutputFormat.INSTANCE);
                break;
            default:
                break;
        }

        String encoding = (String) datamodel.get("encoding");
        if (encoding == null) {
            encoding = cfg.getOutputEncoding();
        }
        response.setCharacterEncoding(encoding);

        try {
            process(tplname, datamodel, response.getWriter());
        } catch (IOException ex) {
            throw new TemplateManagerException("Template error: " + ex.getMessage(), ex);
        }
    }

    //questa versione di activate estrae un modello dati dagli attributi della request
    //this acivate method extracts the data model from the request attributes
    public void activate(String tplname, HttpServletRequest request, HttpServletResponse response) throws TemplateManagerException {
        Map datamodel = getRequestDataModel(request);
        activate(tplname, datamodel, response);
    }

    /**
     * Attiva un template con modello dati esplicito fornito dall'utente
     *
     * @param tplname
     * @param datamodel
     * @param response
     * @param req
     * @throws TemplateManagerException
     */
    public void activate(String tplname, Map datamodel, HttpServletResponse response, HttpServletRequest req) throws TemplateManagerException {
        //impostiamo il content type, se specificato dall'utente, o usiamo il default
        //set the output content type, if user-specified, or use the default
        String contentType = null;
        if (datamodel != null) {
            if (datamodel.containsKey("contentType")) {
                contentType = ((String) datamodel.get("contentType"));
                if (contentType == null) {
                    contentType = "text/html";
                }
            } else {
                contentType = "text/html";
            }
        } else {
            contentType = "text/html";
        }
        response.setContentType(contentType);

        //impostiamo il tipo di output: in questo modo freemarker abiliter� il necessario escaping
        //set the output format, so that freemarker will enable the correspondoing escaping
        switch (contentType) {
            case "text/html":
                cfg.setOutputFormat(HTMLOutputFormat.INSTANCE);
                break;
            case "text/xml":
            case "application/xml":
                cfg.setOutputFormat(XMLOutputFormat.INSTANCE);
                break;
            case "application/json":
                cfg.setOutputFormat(JSONOutputFormat.INSTANCE);
                break;
            default:
                break;
        }

        //impostiamo l'encoding, se specificato dall'utente, o usiamo il default
        //set the output encoding, if user-specified, or use the default
        String encoding = null;
        if (datamodel != null) {
            encoding = (String) datamodel.get("encoding");
            if (encoding == null) {
                encoding = cfg.getOutputEncoding();
            }
        } else {
            encoding = cfg.getOutputEncoding();
        }


        response.setCharacterEncoding(encoding);

        try {
            process(tplname, datamodel, req, response.getWriter());
        } catch (IOException ex) {
            throw new TemplateManagerException("Template error: " + ex.getMessage(), ex);
        }
    }

    //questo metodo principale si occupa di chiamare Freemarker e compilare il template
    //se � stato specificato un template di outline, quello richiesto viene inserito
    //all'interno dell'outline
    //this main method calls Freemarker and compiles the template
    //if an outline template has been specified, the requested template is
    //embedded in the outline
    protected void process(String tplname, Map datamodel,HttpServletRequest request ,Writer out) throws TemplateManagerException {
        Template t;
        //assicuriamoci di avere sempre un data model da passare al template, che contenga anche tutti i default
        //ensure we have a data model, initialized with some default data
        //uso come datamodel di base quello con le infomazioni essenziali come il menu
        Map<String, Object> localdatamodel = getRequestDataModel(request);
        localdatamodel.putAll(getDefaultDataModel());
        //nota: in questo modo il data model utente pu� eventualmente sovrascrivere i dati precaricati da getDefaultDataModel
        //ad esempio per disattivare l'outline template basta porre a null la rispettiva chiave
        //note: in this way, the user data model can possibly overwrite the defaults generated by getDefaultDataModel
        //for example, to disable the outline generation we only need to set null the outline_tpl key
        if (datamodel != null) {
            localdatamodel.putAll(datamodel);
        }
        String outline_name = (String) localdatamodel.get("outline_tpl");
        try {
            if (outline_name == null || outline_name.isEmpty()) {
                //se non c'è un outline, carichiamo semplicemente il template specificato
                //if an outline has not been set, load the specified template
                t = cfg.getTemplate(tplname);
            } else {
                //un template di outline � stato specificato: il template da caricare � quindi sempre l'outline...
                //if an outline template has been specified, load the outline...
                t = cfg.getTemplate(outline_name);
                //...e il template specifico per questa pagina viene indicato all'outline tramite una variabile content_tpl
                //...and pass the requested template name to the outline using the content_tpl variable
                localdatamodel.put("content_tpl", tplname);
                //si suppone che l'outline includa questo secondo template
                //we suppose that the outline template includes this second template somewhere
            }
            //associamo i dati al template e lo mandiamo in output
            //add the data to the template and output the result
            t.process(localdatamodel, out);
        } catch (IOException e) {
            throw new TemplateManagerException("Template error: " + e.getMessage(), e);
        } catch (TemplateException e) {
            throw new TemplateManagerException("Template error: " + e.getMessage(), e);
        }
    }
}