USE hmiltenberger;
ALTER DATABASE hmiltenberger CHARATER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE author(
  authorId BINARY(16) NOT NULL,
  authorActivationToken CHAR(32),
  authorAvatarUrl VARCHAR(255),
  authorEmail VARCHAR(128) NOT NULL,
  authorHash CHAR(97) NOT NULL,
  authorUsername VARCHAR(32) NOT NULL,
  UNIQUE(authorEmail),
  UNIQUE(authorUsername),
  PRIMARY KEY(authorId)
);