CREATE TABLE clients (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE feedbacks (
    id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL REFERENCES clients(id) ON DELETE CASCADE,
    rating SMALLINT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT NOW()
);

INSERT INTO clients (id, name) VALUES (123, 'клиент0');