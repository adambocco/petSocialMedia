CREATE TABLE person(
    email VARCHAR(100),
    password VARCHAR(200) NOT NULL,
    firstName VARCHAR(100) NOT NULL,
    lastName VARCHAR(100) NOT NULL,
    createdAt DATE NOT NULL DEFAULT curdate(),
    PRIMARY KEY(email)
); 

CREATE TABLE pet(
    petID int auto_increment,
    name VARCHAR(100) NOT NULL,
    species varchar(200),
    person VARCHAR(100) NOT NULL,
    PRIMARY KEY(petID),
    FOREIGN KEY(person) REFERENCES person (email)
);

CREATE TABLE meetup(
    meetupID int auto_increment,
    creator VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(500),
    _date VARCHAR(100) NOT NULL,
    _time VARCHAR(100) NOT NULL,
    duration NUMERIC,
    country VARCHAR(100) NOT NULL DEFAULT "USA",
    state VARCHAR(100) NOT NULL DEFAULT "CT",
    PRIMARY KEY(meetupID),
    FOREIGN KEY(creator) REFERENCES person (email)
);

 CREATE TABLE attendee(
    meetupID int NOT NULL,
    person VARCHAR(100) NOT NULL,
    maybeAttending BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY(meetupID, person),
    FOREIGN KEY(person) REFERENCES person(email)
); 

CREATE TABLE recipe(
    recipeID int auto_increment,
    author VARCHAR(100) NOT NULL,
    recipeName VARCHAR(100) NOT NULL,
    description VARCHAR(200),
    ingredients VARCHAR(200),
    timeToMake NUMERIC,
    PRIMARY KEY(recipeID),
    FOREIGN KEY(author) REFERENCES person (email)
); 

CREATE TABLE training(
    trainingID int auto_increment,
    trainer VARCHAR(100) not null,
    location VARCHAR(100),
    description VARCHAR(200),
    price VARCHAR(100),
    _date VARCHAR(100),
    PRIMARY KEY(trainingID),
    FOREIGN KEY(trainer) REFERENCES person (email)
); 

CREATE TABLE trainee(
    trainingID int,
    pet int,
    paid NUMERIC,
    completed NUMERIC,
    PRIMARY KEY(trainingID, pet),
    FOREIGN KEY(trainingID) REFERENCES training (trainingID),
    FOREIGN KEY(pet) REFERENCES pet (petID)
);

 CREATE TABLE friends(
    friendOne varchar(100) NOT NULL,
    friendTwo varchar(100) NOT NULL,
    accepted boolean NOT NULL DEFAULT 0,
    friendsSince DATE DEFAULT curdate(),
    PRIMARY KEY(friendOne, friendTwo),
    FOREIGN KEY(friendOne) REFERENCES person (email),
    FOREIGN KEY(friendTwo) REFERENCES person (email)
); 

CREATE TABLE post(
    postID int auto_increment,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(500),
    person varchar(100) NOT NULL,
    PRIMARY KEY(postID),
    FOREIGN KEY(person) REFERENCES person (email)
); 

CREATE TABLE comment(
    commentID int auto_increment,
    body VARCHAR(100),
    createdAt DATE DEFAULT curdate(),
    postID int NOT NULL,
    pictureID int,
    person varchar(100),
    PRIMARY KEY(commentID),
    FOREIGN KEY(postID) REFERENCES post (postID)
); 

CREATE TABLE picture(
    pictureID int auto_increment,
    filePath VARCHAR(100),
    name VARCHAR(100),
    description VARCHAR(500),
    postID int,
    commentID int,
    pet int,
    PRIMARY KEY(pictureID),
    FOREIGN KEY(postID) REFERENCES post (postID),
    FOREIGN KEY(commentID) REFERENCES comment (commentID),
    FOREIGN KEY(pet) REFERENCES pet (petID)
);

CREATE TABLE bio(
    bioID int auto_increment,
    pet int NOT NULL,
    aboutMe VARCHAR(500),
    country VARCHAR(200),
    state VARCHAR(100),
    town VARCHAR(200),
    PRIMARY KEY(bioID),
    FOREIGN KEY(pet) REFERENCES pet (petID)
);

CREATE TABLE admin(
    adminID int auto_increment,
    adminName VARCHAR(100) NOT NULL,
    adminPassword VARCHAR(100) NOT NULL,
    PRIMARY KEY (adminID)
);