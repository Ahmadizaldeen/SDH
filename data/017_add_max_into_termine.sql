USE 'sdh';
ALTER TABLE termine
ADD COLUMN max_teilnehmer INT DEFAULT 10;