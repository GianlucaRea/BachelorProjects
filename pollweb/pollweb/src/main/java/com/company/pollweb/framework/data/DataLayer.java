package com.company.pollweb.framework.data;

import javax.sql.DataSource;
import java.sql.Connection;
import java.sql.SQLException;
import java.util.HashMap;
import java.util.Map;

public class DataLayer implements AutoCloseable {

    private final DataSource dataSource;
    private Connection connect;
    private final Map<Class, DAO> daos;

    public DataLayer(DataSource dataSource) throws SQLException {
        super();
        this.dataSource = dataSource;
        this.connect = dataSource.getConnection();
        this.daos = new HashMap<>();
    }

    public void registerDAO(Class entityClass, DAO dao) throws DataException {
        daos.put(entityClass, dao);
        dao.init();
    }

    public DAO getDAO(Class entityClass) { return daos.get(entityClass); }

    public void init() throws  DataException {

    }

    public void destroy() {
        try {
            if (connect != null) {
                connect.close();
                connect = null;
            }
        } catch (SQLException ex) {
            ex.printStackTrace();
        }
    }
    public DataSource getDataSource() {
        return this.dataSource;
    }

    public Connection getConnection() {
        return this.connect;
    }

    @Override
    public void close() throws Exception {
        destroy();
    }
}
