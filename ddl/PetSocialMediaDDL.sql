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
    meetupID NUMERIC,
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
    meetupID NUMERIC NOT NULL,
    person VARCHAR(100) NOT NULL,
    maybeAttending BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY(meetupID, person),
    FOREIGN KEY(person) REFERENCES person(email)
); 

CREATE TABLE recipe(
    recipeID NUMERIC,
    author VARCHAR(100) NOT NULL,
    recipeName VARCHAR(100) NOT NULL,
    description VARCHAR(200),
    ingredients VARCHAR(200),
    timeToMake NUMERIC,
    PRIMARY KEY(recipeID),
    FOREIGN KEY(author) REFERENCES person (email)
); 

CREATE TABLE training(
    trainingID NUMERIC,
    pet int NOT NULL,
    location VARCHAR(100),
    description VARCHAR(200),
    price VARCHAR(100),
    _date VARCHAR(100),
    PRIMARY KEY(trainingID),
    FOREIGN KEY(pet) REFERENCES pet (petID)
); 

CREATE TABLE trainee(
    trainingID VARCHAR(100),
    pet int,
    paid NUMERIC,
    completed NUMERIC,
    PRIMARY KEY(trainingID),
    FOREIGN KEY(pet) REFERENCES pet (petID)
);

 CREATE TABLE friends(
    friendOne int NOT NULL,
    friendTwo int NOT NULL,
    friendsSince DATE DEFAULT curdate(),
    PRIMARY KEY(friendOne, friendTwo),
    FOREIGN KEY(friendOne) REFERENCES pet (petID),
    FOREIGN KEY(friendTwo) REFERENCES pet (petID)
); 

CREATE TABLE post(
    postID NUMERIC,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(500),
    pet int NOT NULL,
    PRIMARY KEY(postID),
    FOREIGN KEY(pet) REFERENCES pet (petID)
); 

CREATE TABLE comment(
    commentID NUMERIC,
    body VARCHAR(100),
    createdAt DATE DEFAULT curdate(),
    postID NUMERIC NOT NULL,
    pictureID VARCHAR(100),
    PRIMARY KEY(commentID),
    FOREIGN KEY(postID) REFERENCES post (postID)
); 

CREATE TABLE picture(
    filePath VARCHAR(100),
    name VARCHAR(100),
    description VARCHAR(500),
    postID NUMERIC,
    commentID NUMERIC,
    pet int,
    PRIMARY KEY(filePath),
    FOREIGN KEY(postID) REFERENCES post (postID),
    FOREIGN KEY(commentID) REFERENCES comment (commentID),
    FOREIGN KEY(pet) REFERENCES pet (petID)
);

CREATE TABLE bio(
    bioID NUMERIC,
    pet int NOT NULL,
    aboutMe VARCHAR(500),
    country VARCHAR(200),
    state VARCHAR(100),
    town VARCHAR(200),
    PRIMARY KEY(bioID),
    FOREIGN KEY(pet) REFERENCES pet (petID)
);

CREATE TABLE admin(
    adminID NUMERIC,
    adminName VARCHAR(100) NOT NULL,
    adminPassword VARCHAR(100) NOT NULL,
    PRIMARY KEY (adminID)
);