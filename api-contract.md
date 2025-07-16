📘 Task Management API Contract

📌 Base URL
```
http://127.0.0.1:8000/api
```

---

📂 ENDPOINTS LIST

| Method | Endpoint              | Description                     |
|--------|------------------------|---------------------------------|
| GET    | `/tasks`              | Ambil semua task                |
| GET    | `/tasks/{id}`         | Ambil task berdasarkan ID       |
| POST   | `/tasks`              | Tambah task baru                |
| PUT    | `/tasks/{id}`         | Update task atau ubah status    |
| DELETE | `/tasks/{id}`         | Hapus task                      |

---

🟢 1. GET /tasks
➤ Ambil semua task

Request:
```
GET /api/tasks
```

Response 200 OK
```json
{
  "message": "Data berhasil diambil",
  "data": [
    {
      "id": 1,
      "name": "Belajar RESTful",
      "deadline": "2025-08-01",
      "priority": "high",
      "is_done": false,
      "created_at": "...",
      "updated_at": "..."
    }
  ]
}
```

---

🟢 2. GET /tasks/{id}
➤ Ambil task spesifik berdasarkan ID

Request:
```
GET /api/tasks/1
```

Response 200 OK
```json
{
  "message": "Data berhasil ditemukan",
  "data": {
    "id": 1,
    "name": "Belajar RESTful",
    "deadline": "2025-08-01",
    "priority": "high",
    "is_done": false
  }
}
```

Jika tidak ditemukan
```json
{
  "message": "Task tidak ditemukan"
}
```

---

🟡 3. POST /tasks
➤ Tambah task baru

Request Body
```json
{
  "name": "Belajar RESTful",
  "deadline": "2025-08-01",
  "priority": "high"
}
```

Response 201 Created
```json
{
  "message": "Task berhasil dibuat",
  "data": {
    "id": 1,
    "name": "Belajar RESTful",
    "deadline": "2025-08-01",
    "priority": "high",
    "is_done": false
  }
}
```

Jika validasi gagal
```json
{
  "message": "Validasi gagal",
  "errors": {
    "name": ["The name field is required."]
  }
}
```

---

🔵 4. PUT /tasks/{id}
➤ Update task atau ubah status `is_done`

Request Body
```json
{
  "name": "Update Task",
  "deadline": "2025-09-01",
  "priority": "normal",
  "is_done": true
}
```

Response 200 OK
```json
{
  "message": "Task berhasil diupdate",
  "data": {
    "id": 1,
    "name": "Update Task",
    "deadline": "2025-09-01",
    "priority": "normal",
    "is_done": true
  }
}
```

---

🔴 5. DELETE /tasks/{id}
➤ Hapus task berdasarkan ID

Response 200 OK
```json
{
  "message": "Task berhasil dihapus"
}
```

Jika tidak ditemukan
```json
{
  "message": "Task tidak ditemukan"
}
```

---

✨ Catatan Tambahan

- Semua error `404` dan `validation` tidak load berat dan langsung balikan respon.
- Field `is_done` bisa diubah lewat PUT — tidak perlu endpoint toggle lagi.
- GET `/tasks` dan `/tasks/{id}` sudah digabung dalam 1 controller function (`index`).