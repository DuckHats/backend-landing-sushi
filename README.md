```bash
curl -X POST http://landing-back.test/api/reservations \
 -H "Content-Type: application/json" \
 -H "Accept: application/json" \
 -d '{
"name": "Joan Garcia",
"email": "joan@example.com",
"phone": "666777888",
"persons": 4,
"date_time": "2025-01-20 20:30:00",
"intolerances": "Gluten",
"honey_pot": ""
}'
```

Expected Result: JSON { "message": "Reserva solicitada correctamente...", "status": "success" } and an email logged/sent to Admin.

```bash
curl -X POST http://landing-back.test/api/delivery-orders \
 -H "Content-Type: application/json" \
 -H "Accept: application/json" \
 -d '{
"name": "Maria Lopez",
"email": "maria@example.com",
"phone": "666111222",
"address": "Carrer Major 1",
"payment_method": "cash",
"products": [
{"id": 1, "quantity": 2},
{"id": 2, "quantity": 1}
],
"honey_pot": ""
}'
```

Expected Result: JSON { "message": "Pedido recibido correctamente!", ... } and an email logged/sent to Admin.

Add "honey_pot": "im_a_bot" to the payload. Expected Result: 422 Unprocessable Entity or JSON { "message": "Spam detectado" }.
