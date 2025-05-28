import React, { useState, useEffect } from 'react';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-react';

export default function EmployeesIndex() {
  const { employees: initialEmployees } = usePage().props;
  const [employees, setEmployees] = useState(initialEmployees.data || []);
  const [search, setSearch] = useState('');
  const [department, setDepartment] = useState('');
  const [position, setPosition] = useState('');
  const [loading, setLoading] = useState(false);

  // ฟังก์ชันโหลดข้อมูลจาก API ด้วย filter
  const fetchEmployees = () => {
    setLoading(true);
    let url = '/api/employees?';
    if (search) url += `search=${encodeURIComponent(search)}&`;
    if (department) url += `department=${encodeURIComponent(department)}&`;
    if (position) url += `position=${encodeURIComponent(position)}&`;

    fetch(url)
      .then(res => res.json())
      .then(data => {
        setEmployees(data.data);
        setLoading(false);
      });
  };

  useEffect(() => {
    fetchEmployees();
  }, []);

  const handleDelete = (id) => {
    if (!confirm('คุณต้องการลบพนักงานนี้หรือไม่?')) return;
    Inertia.delete(`/api/employees/${id}`, {
      onSuccess: () => fetchEmployees(),
    });
  };

  return (
    <div className="container mt-4">
      <h1>รายชื่อพนักงาน</h1>

      <div className="row mb-3">
        <div className="col-md-4">
          <input
            type="text"
            className="form-control"
            placeholder="ค้นหาชื่อ"
            value={search}
            onChange={e => setSearch(e.target.value)}
          />
        </div>
        <div className="col-md-3">
          <input
            type="text"
            className="form-control"
            placeholder="กรองแผนก"
            value={department}
            onChange={e => setDepartment(e.target.value)}
          />
        </div>
        <div className="col-md-3">
          <input
            type="text"
            className="form-control"
            placeholder="กรองตำแหน่ง"
            value={position}
            onChange={e => setPosition(e.target.value)}
          />
        </div>
        <div className="col-md-2">
          <button
            className="btn btn-primary w-100"
            onClick={fetchEmployees}
            disabled={loading}
          >
            ค้นหา
          </button>
        </div>
      </div>
      <div className="mb-3 text-end">
  <a href="/employees/create" className="btn btn-primary">
    เพิ่มพนักงาน
  </a>
</div>


      <table className="table table-bordered">
        <thead>
          <tr>
            <th>รูปโปรไฟล์</th>
            <th>ชื่อ</th>
            <th>ตำแหน่ง</th>
            <th>เงินเดือน</th>
            <th>แผนก</th>
            <th>จัดการ</th>
          </tr>
        </thead>
        <tbody>
          {employees.length === 0 && (
            <tr>
              <td colSpan="6" className="text-center">
                ไม่พบข้อมูล
              </td>
            </tr>
          )}
          {employees.map(emp => (
            <tr key={emp.id}>
              <td>
                {emp.profile_photo_path ? (
                  <img
                    src={`/storage/${emp.profile_photo_path}`}
                    alt={emp.name}
                    width="60"
                    height="60"
                    className="rounded-circle"
                  />
                ) : (
                  <div
                    style={{
                      width: 60,
                      height: 60,
                      backgroundColor: '#ddd',
                      borderRadius: '50%',
                      display: 'inline-block',
                    }}
                  />
                )}
              </td>
              <td>{emp.name}</td>
              <td>{emp.position}</td>
              <td>{emp.salary.toLocaleString()}</td>
              <td>{emp.department}</td>
              <td>
                <button
                  className="btn btn-sm btn-warning me-2"
                  onClick={()
