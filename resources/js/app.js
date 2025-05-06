import React, { useState } from 'react';
import './App.css';

function App() {
  const initialRooms = [
    { id: 1, name: 'ห้อง 101', booked: false },
    { id: 2, name: 'ห้อง 102', booked: false },
    { id: 3, name: 'ห้อง 103', booked: false },
  ];

  const [rooms, setRooms] = useState(initialRooms);

  const toggleBooking = (id) => {
    setRooms(prevRooms =>
      prevRooms.map(room =>
        room.id === id ? { ...room, booked: !room.booked } : room
      )
    );
  };

  return (
    <div className="container">
      <h1>ระบบการจองห้องพัก</h1>
      {rooms.map(room => (
        <div key={room.id} className={`room ${room.booked ? 'booked' : 'available'}`}>
          <h3>{room.name}</h3>
          <p>สถานะ: {room.booked ? 'จองแล้ว' : 'ว่าง'}</p>
          <button onClick={() => toggleBooking(room.id)}>
            {room.booked ? 'ยกเลิกการจอง' : 'จองห้อง'}
          </button>
        </div>
      ))}
    </div>
  );
}

export default App;
