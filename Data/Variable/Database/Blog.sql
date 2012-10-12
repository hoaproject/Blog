DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS comment;

CREATE TABLE post (
    id      INTEGER,
    title   VARCHAR(255),
    posted  TIMESTAMP,
    content LONGVARCHAR,

    PRIMARY KEY(id)
);

CREATE TABLE comment (
    id      INTEGER,
    post    INTEGER,
    author  VARCHAR(31),
    posted  TIMESTAMP,
    content LONGVARCHAR,

    PRIMARY KEY(id),
    FOREIGN KEY(post) REFERENCES post(id)
);

CREATE TABLE user (
    name     VARCHAR(31),
    password VARCHAR(40),

    PRIMARY KEY(name)
);

INSERT INTO post ( id, title, posted, content ) VALUES (
    0,
    'Call me Ph.D!',
    942879600,
    'My thesis was accepted. What a long labor! Well, it is finally over. The harder part was to resume the title. You know, in Theoretical Physics, thesis have always very short and concise titles. Mine is quite simple; here it is: Observation of Einstein-Podolsky-Rosen Entanglement on Supraquantum Structures by Induction Through Nonlinear Transuranic Crystal of Extremely Long Wavelength (ELW) Pulse from Mode-Locked Source Array. I can gladly send you a copy if you want.');

INSERT INTO post ( id, title, posted, content ) VALUES (
    1,
    'Dr. Isaac Kleiner, my mentor, has hired me at Black Mesa Research Facility',
    957477600,
    'Well, I was so disappointed by the weak interest of university for teleportation that I decided to look for a job in the private sector. But, you know, life is awesome. How lucky I am. My mentor, Dr. Isaac Kleiner, proposed me a job at the Black Mesa Research \o/. Really excited to start.'
);

INSERT INTO post ( id, title, posted, content ) VALUES (
    2,
    'Great party in the Anomalous Materials department with collegues!',
    976834800,
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu libero nisi, nec convallis tortor. Quisque non malesuada turpis. Aliquam rhoncus, erat eget fermentum gravida, nisi odio porta nisi, ac imperdiet dolor arcu sit amet nulla. Curabitur turpis nunc, sagittis a suscipit ut, scelerisque ac justo. Duis urna risus, fringilla et porta eget, dictum pulvinar magna. In quis auctor massa.'
);

INSERT INTO post ( id, title, posted, content ) VALUES (
    3,
    'I think I have made a blunder at Black Mesa',
    976921200,
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu libero nisi, nec convallis tortor. Quisque non malesuada turpis. Aliquam rhoncus, erat eget fermentum gravida, nisi odio porta nisi, ac imperdiet dolor arcu sit amet nulla. Curabitur turpis nunc, sagittis a suscipit ut, scelerisque ac justo. Duis urna risus, fringilla et porta eget, dictum pulvinar magna. In quis auctor massa.'
);

INSERT INTO post ( id, title, posted, content ) VALUES (
    4,
    'ping -f Nihilanth',
    978476400,
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu libero nisi, nec convallis tortor. Quisque non malesuada turpis. Aliquam rhoncus, erat eget fermentum gravida, nisi odio porta nisi, ac imperdiet dolor arcu sit amet nulla. Curabitur turpis nunc, sagittis a suscipit ut, scelerisque ac justo. Duis urna risus, fringilla et porta eget, dictum pulvinar magna. In quis auctor massa.'
);

INSERT INTO post ( id, title, posted, content ) VALUES (
    5,
    'G-Man or the hard deal',
    978822000,
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu libero nisi, nec convallis tortor. Quisque non malesuada turpis. Aliquam rhoncus, erat eget fermentum gravida, nisi odio porta nisi, ac imperdiet dolor arcu sit amet nulla. Curabitur turpis nunc, sagittis a suscipit ut, scelerisque ac justo. Duis urna risus, fringilla et porta eget, dictum pulvinar magna. In quis auctor massa.'
);



INSERT INTO comment ( id, post, author, posted, content ) VALUES (
    0,
    0,
    'Isaac Kleiner',
    945610740,
    'Nice work Gordon. Hope we will work together in a near future!'
);

INSERT INTO comment ( id, post, author, posted, content ) VALUES (
    1,
    0,
    'Mummy',
    945610740,
    'I really donnot understand what you do but I am very proud of my little Gordy :-). xoxo, your Mummy.'
);

INSERT INTO comment ( id, post, author, posted, content ) VALUES (
    2,
    1,
    'Isaac Kleiner',
    945610740,
    'You are welcome. We are honoured you accepted the job :-).'
);

INSERT INTO comment ( id, post, author, posted, content ) VALUES (
    3,
    1,
    'Eli Vance',
    945610740,
    'Glad to know we have a new genius with us! You will find me in the sector C and sometimes near the teleportation laboratories in the Lambda Complex.  Maybe we could diner together, accompanied by my wife Azian and my little sweety Alyx!'
);

INSERT INTO comment ( id, post, author, posted, content ) VALUES (
    4,
    3,
    'Isaac Kleiner',
    945610740,
    'Nulla euismod lacinia condimentum. Suspendisse hendrerit libero ac enim ultrices mattis. Curabitur consectetur, augue sagittis molestie euismod, justo magna ultricies ante, vehicula mollis eros odio non turpis. Nunc at justo vel odio.'
);

INSERT INTO comment ( id, post, author, posted, content ) VALUES (
    5,
    3,
    'Isaac Kleiner',
    945610740,
    'Nulla euismod lacinia condimentum. Suspendisse hendrerit libero ac enim ultrices mattis. Curabitur consectetur, augue sagittis molestie euismod, justo magna ultricies ante, vehicula mollis eros odio non turpis. Nunc at justo vel odio.'
);

INSERT INTO comment ( id, post, author, posted, content ) VALUES (
    6,
    3,
    'Isaac Kleiner',
    945610740,
    'Nulla euismod lacinia condimentum. Suspendisse hendrerit libero ac enim ultrices mattis. Curabitur consectetur, augue sagittis molestie euismod, justo magna ultricies ante, vehicula mollis eros odio non turpis. Nunc at justo vel odio.'
);

INSERT INTO comment ( id, post, author, posted, content ) VALUES (
    7,
    4,
    'Isaac Kleiner',
    945610740,
    'Nulla euismod lacinia condimentum. Suspendisse hendrerit libero ac enim ultrices mattis. Curabitur consectetur, augue sagittis molestie euismod, justo magna ultricies ante, vehicula mollis eros odio non turpis. Nunc at justo vel odio.'
);

INSERT INTO comment ( id, post, author, posted, content ) VALUES (
    8,
    5,
    'Isaac Kleiner',
    945610740,
    'Nulla euismod lacinia condimentum. Suspendisse hendrerit libero ac enim ultrices mattis. Curabitur consectetur, augue sagittis molestie euismod, justo magna ultricies ante, vehicula mollis eros odio non turpis. Nunc at justo vel odio.'
);

INSERT INTO comment ( id, post, author, posted, content ) VALUES (
    9,
    5,
    'Isaac Kleiner',
    945610740,
    'Nulla euismod lacinia condimentum. Suspendisse hendrerit libero ac enim ultrices mattis. Curabitur consectetur, augue sagittis molestie euismod, justo magna ultricies ante, vehicula mollis eros odio non turpis. Nunc at justo vel odio.'
);

INSERT INTO comment ( id, post, author, posted, content ) VALUES (
    10,
    5,
    'Isaac Kleiner',
    945610740,
    'Nulla euismod lacinia condimentum. Suspendisse hendrerit libero ac enim ultrices mattis. Curabitur consectetur, augue sagittis molestie euismod, justo magna ultricies ante, vehicula mollis eros odio non turpis. Nunc at justo vel odio.'
);

INSERT INTO user ( name, password ) VALUES (
    'hywan',
    '8843d7f92416211de9ebb963ff4ce28125932878'
);

INSERT INTO user ( name, password ) VALUES (
    'iraphael',
    '8843d7f92416211de9ebb963ff4ce28125932878'
);
