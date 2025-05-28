import React, { useState, useEffect } from 'react';
import { useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-react';

export default function CreateEdit({ employee = null }) {
  const { flash } = usePage().props;

  const { data, setData, post, put, processing, errors, reset } = useForm({
    name: employee?.name || '',
    position: employee?.position || '',
    salary: employee?.salary || '',
    department: employee?.department || '',
    profile_photo: null,
  });

  const handleSubmit = (e) => {
    e.preventDefault();

    if (employee) {
      Inertia.post(`/api/employees/${employee.id}?_method=PUT`, data, {
        onSuccess: () => {
          alert('บันทึกเรียบร้อย');
          Inertia.visit('/employees');
        },
      });
    } else {
      post('/api/employees', {
        onSuccess: () => {
          alert('เพิ่มข้อมูลสำเร็จ');
          Inertia.visit('/employees');
        },
      });
    }
  };

  return (
    <div className="container mt-4">
      <h2>{employee ? 'แก้ไขพนักงาน' : 'เพิ่มพนักงาน'}</h2>

      <form onSubmit={handleSubmit} encType="multipart/form-data">
        <div className="mb-3">
          <label>ชื่อ</label>
          <input
            type="text"
            className={`form-control ${errors.name && 'is-invalid'}`}
            value={data.name}
            onChange={(e) => setData('name', e.target.value)}
          />
          {errors.name && <div className="invalid-feedback">{errors.name}</div>}
        </div>

        <div className="mb-3">
          <label>ตำแหน่ง</label>
          <input
            type="text"
            className={`form-control ${errors.position && 'is-invalid'}`}
            value={data.position}
            onChange={(e) => setData('position', e.target.value)}
          />
          {errors.position && <div className="invalid-feedback">{errors.position}</div>}
        </div>

        <div className="mb-3">
          <label>เงินเดือน</label>
          <input
            type="number"
            className={`form-control ${errors.salary && 'is-invalid'}`}
            value={data.salary}
            onChange={(e) => setData('salary', e.target.value)}
          />
          {errors.salary && <div className="invalid-feedback">{errors.salary}</div>}
        </div>

        <div className="mb-3">
          <label>แผนก</label>
          <input
            type="text"
            className={`form-control ${errors.department && 'is-invalid'}`}
            value={data.department}
            onChange={(e) => setData('department', e.target.value)}
          />
          {errors.department && <div className="invalid-feedback">{errors.department}</div>}
        </div>

        <div className="mb-3">
          <label>รูปโปรไฟล์ (ไม่บังคับ)</label>
          <input
            type="file"
            className={`form-control ${errors.profile_photo && 'is-invalid'}`}
            onChange={(e) => setData('profile_photo', e.target.files[0])}
          />
          {errors.profile_photo && <div className="invalid-feedback">{errors.profile_photo}</div>}
        </div>

        {employee?.profile_photo_path && (
          <div className="mb-3">
            <img
              src={`/storage/${employee.profile_photo_path}`}
              alt="รูปเดิม"
              width="100"
              className="rounded"
            />
          </div>
        )}

        <button type="submit" className="btn btn-success" disabled={processing}>
          {employee ? 'อัปเดต' : 'เพิ่ม'}
        </button>
      </form>
    </div>
  );
}
