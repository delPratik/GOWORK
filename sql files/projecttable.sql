-- Create the 'project' table
CREATE TABLE project (
  project_id INT AUTO_INCREMENT,
  project_title VARCHAR(255),
  category VARCHAR(255),
  budget DECIMAL(10, 2),
  deadline DATE,
  description VARCHAR(255),
  status VARCHAR(255) DEFAULT 'Unapproved', -- Add the 'status' column with a default value
  PRIMARY KEY (project_id)
);

ALTER TABLE project
ADD client_name VARCHAR(255);

ALTER table project
Add freelancer_name VARCHAR(255);

-- Alter the 'project' table to add 'work' column
ALTER TABLE project
ADD work VARCHAR(10);

ALTER TABLE project
ADD work_file LONGBLOB;

