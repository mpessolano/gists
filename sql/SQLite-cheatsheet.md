# SQLite Cheatsheet

Learn SQL | [Codeacademy](https://www.codecademy.com/courses/learn-sql)

## Queries

- ### SELECT

```sql
SELECT * FROM celebs;
```

---

## Manipulation

- ### CREATE

```sql
CREATE TABLE celebs (
  id INTEGER,
  name TEXT,
  age INTEGER
);
```

- ### INSERT

```sql
INSERT INTO celebs (id, name, age)
VALUES (1, 'Justin Bieber', 22);

INSERT INTO celebs (id, name, age)
VALUES (2, 'Beyonce Knowles', 33);

INSERT INTO celebs (id, name, age)
VALUES (3, 'Jeremy Lin', 26);

INSERT INTO celebs (id, name, age)
VALUES (4, 'Taylor Swift', 26);
```
