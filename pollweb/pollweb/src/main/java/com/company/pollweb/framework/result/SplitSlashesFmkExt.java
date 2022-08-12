/*
 * Implementando l'interfaccia TemplateMethodModelEx e' possibile creare funzioni
 * richiamabili all'interno dei template di Freemarker. Si veda la classe MakeArticle per
 * un esempio di uso.
 * Implementing the TemplateMethodModelEx interface it is possible to create functions
 * that can be called within a Freemarker template. See the MakeArticle class for
 * an example.
 */
package com.company.pollweb.framework.result;

import freemarker.template.TemplateMethodModelEx;
import freemarker.template.TemplateModelException;
import com.company.pollweb.framework.security.SecurityLayer;

import java.util.List;

/**
 *
 * @author Giuseppe Della Penna
 */
public class SplitSlashesFmkExt implements TemplateMethodModelEx {

    @Override
    public Object exec(List list) throws TemplateModelException {
        //la lista contiene i parametri passati alla funzione nel template
        //the list contains the parameters passed to the function in the template
        if (!list.isEmpty()) {
            return SecurityLayer.stripSlashes(list.get(0).toString());
        } else {
            //e' possibile ritornare qualsiasi tipo che sia gestibile da Freemarker (scalari, hash, liste)
            //it is possible tor eturn any data type recognized by Freemarker (scalars, hashes, lists)
            return "";
        }
    }
}
