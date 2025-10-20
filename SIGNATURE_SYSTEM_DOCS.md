# 🖋️ Digital Signature System Documentation

## 📋 Overview
Complete digital signature system for mahasiswa (students) with database storage, file management, and interactive signature pad using Signature Pad 4.0.0.

## 🗄️ Database Structure

### Migration: `2025_10_21_000000_create_user_signatures_table.php`
```sql
CREATE TABLE user_signatures (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    signature_path VARCHAR(255) NULL,
    original_filename VARCHAR(255) NULL,
    file_type VARCHAR(255) DEFAULT 'png',
    file_size INT NULL,
    signature_data JSON NULL,
    is_active BOOLEAN DEFAULT TRUE,
    purpose VARCHAR(255) NULL,
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_active (user_id, is_active),
    INDEX idx_user_purpose (user_id, purpose)
);
```

### Model: `UserSignature.php`
```php
- Relationships: belongsTo(User::class)
- Accessors: getSignatureUrlAttribute(), getFormattedFileSizeAttribute()
- Scopes: active(), byPurpose(), latest()
- Features: JSON casting for signature_data
```

## 🎯 Features Implemented

### 1. **Interactive Signature Canvas**
- ✅ HTML5 Canvas with Signature Pad 4.0.0
- ✅ Touch and mouse support
- ✅ Responsive design with proper scaling
- ✅ Real-time signature preview

### 2. **Signature Controls**
- ✅ **Undo**: Step-by-step undo functionality
- ✅ **Clear**: Complete canvas clear
- ✅ **Save**: Save signature to database and storage

### 3. **File Management**
- ✅ PNG format signatures
- ✅ Base64 to file conversion
- ✅ Automatic file naming: `signature_{user_id}_{timestamp}.png`
- ✅ Storage in `storage/app/public/user_signatures/`
- ✅ File size tracking and formatting

### 4. **Database Integration**
- ✅ Foreign key relationship with users table
- ✅ Active signature management (one active per user)
- ✅ Purpose categorization (general, proposal, document, etc.)
- ✅ Notes and metadata storage
- ✅ Backup base64 data storage

### 5. **User Interface**
- ✅ Modern card-based layout
- ✅ Purple theme integration (#29166F)
- ✅ Responsive design
- ✅ Real-time notifications
- ✅ Signature history with thumbnails

## 🔧 API Endpoints

### Show Signature Page
```http
GET /mahasiswa/signature
Returns: Signature creation page with active signature and history
```

### Save Signature
```http
POST /mahasiswa/save-signature
Content-Type: application/json

Body:
{
    "signature_data": "data:image/png;base64,iVBORw0KGgoAAAANSU...",
    "purpose": "proposal",
    "notes": "For internship proposal"
}

Response:
{
    "success": true,
    "message": "Signature berhasil disimpan",
    "signature": {
        "id": 1,
        "url": "http://localhost/storage/user_signatures/signature_1_1729123456.png",
        "created_at": "21 Oct 2025 10:30",
        "file_size": "15.2 KB"
    }
}
```

### Get User Signatures
```http
GET /mahasiswa/get-signatures
Accept: application/json

Response:
{
    "success": true,
    "signatures": [...],
    "total": 3
}
```

### Set Active Signature
```http
POST /mahasiswa/signature/{signatureId}/set-active

Response:
{
    "success": true,
    "message": "Signature aktif berhasil diubah"
}
```

### Delete Signature
```http
DELETE /mahasiswa/signature/{signatureId}

Response:
{
    "success": true,
    "message": "Signature berhasil dihapus"
}
```

### Download Signature
```http
GET /mahasiswa/signature/{signatureId}/download
Returns: PNG file download
```

## 🎨 UI Components

### 1. **Signature Canvas**
```html
<canvas id="signatureCanvas" class="signature-canvas"></canvas>
<div class="signature-placeholder">
    <i class="fas fa-pen-nib"></i>
    <p>Tanda tangan Anda di sini</p>
</div>
```

### 2. **Control Buttons**
```html
<button id="undoBtn">Undo</button>
<button id="clearBtn">Clear</button>
<button id="saveBtn">Save Signature</button>
```

### 3. **Purpose Selection**
```html
<select id="signaturePurpose">
    <option value="general">Umum</option>
    <option value="proposal">Proposal Magang</option>
    <option value="document">Dokumen Resmi</option>
    <option value="assignment">Tugas Kuliah</option>
    <option value="thesis">Skripsi/Tesis</option>
</select>
```

### 4. **Signature History**
- Thumbnail previews
- Active signature indicator
- Action buttons (Preview, Set Active, Delete)
- File information display

## 📱 JavaScript Features

### 1. **Signature Pad Initialization**
```javascript
signaturePad = new SignaturePad(canvas, {
    backgroundColor: 'rgb(255, 255, 255)',
    penColor: 'rgb(0, 0, 0)',
    minWidth: 1,
    maxWidth: 3,
    throttle: 16,
    minPointDistance: 3,
});
```

### 2. **Responsive Canvas**
- Automatic resize on window change
- Device pixel ratio handling
- Touch and mouse events

### 3. **Undo System**
```javascript
// Store signature history for undo
signaturePad.addEventListener('endStroke', function() {
    signatureHistory.push(signaturePad.toData());
});
```

### 4. **AJAX Operations**
- Save signature without page reload
- Real-time history updates
- Error handling with notifications

## 🔒 Security Features

### 1. **File Validation**
- PNG format only
- Base64 validation
- File size limits
- Secure file storage

### 2. **Access Control**
- User can only access own signatures
- CSRF protection on all forms
- Authentication required

### 3. **Database Security**
- Foreign key constraints
- Soft delete capability
- Indexed queries for performance

## 📊 Data Flow

### 1. **Create Signature**
```
User draws → Canvas captures → Convert to base64 → 
Validate → Save to storage → Create DB record → 
Update UI → Show success
```

### 2. **Set Active Signature**
```
User selects → Deactivate all signatures → 
Activate selected → Update UI → Refresh display
```

### 3. **Delete Signature**
```
User confirms → Check ownership → Delete file → 
Delete DB record → Update history → Show notification
```

## 🚀 Usage Examples

### Access Signature Page
```
Navigate to: /mahasiswa/signature
Or click "Digital Signature" in sidebar
```

### Create New Signature
1. Draw signature on canvas
2. Use Undo/Clear controls as needed
3. Select purpose and add notes
4. Click "Save Signature"

### Manage Signatures
1. View history in bottom section
2. Preview signatures in modal
3. Set active signature
4. Download or delete as needed

## 🔄 Integration with Other Systems

### 1. **User Model Relationship**
```php
// Get user's active signature
$activeSignature = $user->activeSignature;

// Get all user signatures
$signatures = $user->signatures()->latest()->get();
```

### 2. **Usage in Forms/Documents**
```php
// Display active signature in proposal
@if($user->activeSignature)
    <img src="{{ $user->activeSignature->signature_url }}" alt="Signature">
@endif
```

### 3. **API Integration**
```javascript
// Get signature for use in other forms
fetch('/mahasiswa/get-signatures')
    .then(response => response.json())
    .then(data => {
        const activeSignature = data.signatures.find(s => s.is_active);
        // Use signature in form
    });
```

## 📈 Performance Considerations

### 1. **File Storage**
- PNG compression for optimal size
- Organized directory structure
- Cleanup of unused signatures

### 2. **Database Optimization**
- Indexed queries for user_id
- JSON storage for backup data
- Efficient active signature queries

### 3. **Frontend Optimization**
- Canvas resize handling
- Lazy loading of signature history
- Optimized signature pad settings

The digital signature system is now fully functional and ready for use! 🖋️✨