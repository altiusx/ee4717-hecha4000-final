CREATE TABLE feedback (
    feedbackID int unsigned not null auto_increment PRIMARY KEY,
    feedbackName varchar(50) not null,
    feedbackEmail varchar(100) not null,
    feedbackMessage text not null
);

CREATE TABLE customers(
    custid int unsigned not null auto_increment PRIMARY KEY,
    custname varchar(50) not null,
    custemail varchar(100) not null,
    custpw varchar(40) not null,
    custaddress varchar(100) not null,
    custcardno char(20) not null,
    custcardexpiryMM char(2) not null,
    custcardexpiryYY char(2) not null,
    custCVV char(3) not null
);

CREATE TABLE orders(
    orderid int unsigned not null auto_increment,
    custid int unsigned not null,
    totalamount float(6,2) not null,
    date date not null,
    currentstatus text not null,
    PRIMARY KEY (orderid),
    FOREIGN KEY (custid) REFERENCES customers(custid)
);

CREATE TABLE pricelist(
    itemid int unsigned not null auto_increment PRIMARY KEY,
    item varchar(30) not null,
    unitprice float(4,2) not null
);

CREATE TABLE stocklist(
    stockid int unsigned not null auto_increment,
    itemid int unsigned not null,
    stockqty int unsigned not null,
    PRIMARY KEY (stockid),
    FOREIGN KEY (itemid) REFERENCES pricelist(itemid)
);

CREATE TABLE signaturedrinks(
    signatureid int unsigned not null auto_increment,
    orderid int unsigned not null,
    CQty tinyint unsigned not null,
    MQty tinyint unsigned not null,
    DQty tinyint unsigned not null,
    CSubtotal float(6,2) not null,
    MSubtotal float(6,2) not null,
    DSubtotal float(6,2) not null,
    PRIMARY KEY (signatureid),
    FOREIGN KEY (orderid) REFERENCES orders(orderid)
);

CREATE TABLE DIYdrinks(
    DIYid int unsigned not null auto_increment,
    orderid int unsigned not null,
    teatype varchar(20) not null,
    addCream tinyint not null,
    addFreshmilk tinyint not null,
    addMilkfoam tinyint not null,
    addPearls tinyint not null,
    addCoconutjelly tinyint not null,
    addGrassjelly tinyint not null,
    sugarlevel varchar(20) not null,
    icelevel varchar(20) not null,
    DIYprice float(4,2) not null,
    PRIMARY KEY (DIYid),
    FOREIGN KEY (orderid) REFERENCES orders(orderid)
);