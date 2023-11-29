-- Create the proposals table
CREATE TABLE proposals (
    proposal_id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    freelancer_name VARCHAR(255),
    budget DECIMAL(10, 2),
    deadline DATE,
    FOREIGN KEY (project_id) REFERENCES project(project_id)
);

-- Add a column to the proposals table
ALTER TABLE proposals
ADD COLUMN project_title VARCHAR(255);
