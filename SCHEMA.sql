-- TABLE TASK todolist
CREATE TABLE tasks (
    task_id SERIAL PRIMARY KEY,
    task_label VARCHAR(500),
    task_status_id INT REFERENCES task_status(task_status_id) ON DELETE RESTRICT,
    task_creation_date  DATE DEFAULT CURRENT_DATE,
    task_completion_date DATE,
    task_is_deleted BOOLEAN DEFAULT FALSE NOT NULL
);

-- STATUS OF TASKS
CREATE TABLE task_status (
    task_status_id SERIAL PRIMARY KEY,
    task_status_label VARCHAR(100)
);

INSERT INTO task_status (task_status_label) VALUES ('in progress'), ('completed');

