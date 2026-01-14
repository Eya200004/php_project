# ENSA Safi Absence Management System - Frontend

A comprehensive React + Vite frontend application for managing student absences at ENSA Safi (École Nationale des Sciences Appliquées Safi). The system provides role-based interfaces for administrators, teachers, and students with institutional branding and professional design.

## Project Overview

This is a modern, institutional-grade absence management system designed specifically for ENSA Safi. The application features:

- **Role-Based Access Control**: Separate dashboards for Admin, Teacher, and Student roles
- **Professional Branding**: ENSA Safi institutional colors and typography
- **Responsive Design**: Mobile-first approach with tablet and desktop support
- **Real-Time Integration**: Connected to Laravel backend APIs
- **Institutional Design Philosophy**: Modern minimalism with Moroccan heritage influence

## Technology Stack

- **Frontend Framework**: React 19 with TypeScript
- **Build Tool**: Vite 7
- **Styling**: Tailwind CSS 4 with custom ENSA Safi theme
- **UI Components**: shadcn/ui
- **State Management**: React Context API
- **Routing**: Wouter
- **HTTP Client**: Fetch API
- **Icons**: Lucide React
- **Notifications**: Sonner
- **Form Handling**: React Hook Form

## Design Philosophy

### Color Palette

- **Primary Navy Blue** (#1a3a52): Authority, trust, institutional identity
- **Warm Terracotta** (#d97706): Accent color, highlights, important CTAs
- **Light Cream** (#faf8f3): Warm white background, reduces eye strain
- **Charcoal Gray** (#2d3748): Text color for excellent readability

### Typography

- **Display Font**: Poppins (Bold 700) - Headers and titles
- **Body Font**: Inter (Regular 400, Medium 500) - Body text and UI labels

### Layout Principles

- Asymmetric sidebar navigation (left, 260px)
- Full-width content area with generous margins
- No centered layouts - content flows naturally
- Responsive breakpoints: Mobile (320px), Tablet (768px), Desktop (1024px+)

## Project Structure

```
client/
├── public/                 # Static assets
│   └── images/            # Image assets
├── src/
│   ├── pages/             # Page components
│   │   ├── Login.tsx      # Common login page
│   │   ├── admin/         # Admin pages
│   │   ├── teacher/       # Teacher pages
│   │   ├── student/       # Student pages
│   │   └── NotFound.tsx   # 404 page
│   ├── components/        # Reusable components
│   │   ├── Sidebar.tsx    # Role-based navigation
│   │   ├── DashboardLayout.tsx  # Dashboard wrapper
│   │   ├── ProtectedRoute.tsx   # Route protection
│   │   └── ui/            # shadcn/ui components
│   ├── contexts/          # React contexts
│   │   ├── AuthContext.tsx      # Authentication state
│   │   └── ThemeContext.tsx     # Theme management
│   ├── lib/               # Utility functions
│   │   └── api.ts         # Backend API service layer
│   ├── App.tsx            # Main app component with routes
│   ├── main.tsx           # React entry point
│   └── index.css          # Global styles and theme
├── index.html             # HTML template
└── package.json           # Dependencies and scripts
```

## Features by Role

### Admin Dashboard

- **Dashboard Overview**: KPIs including total students, teachers, programs, and attendance rates
- **Student Management**:
  - Filter by program (CP1, CP2, GIIA, GPMA, INDUS, GATE, GMSI, GTR)
  - Filter by semester (1-6)
  - Filter by academic year
  - Edit student information
  - Delete students with confirmation
  - Search by name, email, or apogee number
- **Teacher Management**: View and manage teachers
- **Program Management**: Manage academic programs and filières
- **Module Management**: Manage courses and modules
- **Schedule Management**: View and manage class schedules
- **Reports & Analytics**: View detailed reports and statistics
- **Settings**: System configuration

### Teacher Dashboard

- **Dashboard Overview**: Modules, students, attendance rates, pending tasks
- **Module Management**: View and manage assigned modules
- **Class Management**: Manage classes and student lists
- **Attendance Tracking**: Mark and track student attendance
- **Document Management**: Upload and manage course materials
- **Announcements**: Post announcements to students
- **Settings**: Profile and preference management

### Student Dashboard

- **Dashboard Overview**: Absence statistics (justified, unjustified, total, attendance rate)
- **Absence Tracking**: View detailed absence records
- **Module View**: See enrolled modules and progress
- **Document Access**: Download course materials
- **Announcements**: View teacher announcements
- **Settings**: Profile and preference management

## Getting Started

### Prerequisites

- Node.js 22.13.0+
- pnpm 10.4.1+

### Installation

1. **Install dependencies**:
   ```bash
   pnpm install
   ```

2. **Start development server**:
   ```bash
   pnpm dev
   ```

3. **Open in browser**:
   Navigate to `http://localhost:3000`

### Backend Configuration

The frontend connects to a Laravel backend at `http://localhost:8000/api`. Make sure your backend is running before testing the application.

**Backend API Endpoints Used**:
- `/api/users/login` - User authentication
- `/api/etudiants` - Student management
- `/api/enseignants` - Teacher management
- `/api/filieres` - Program management
- `/api/modules` - Module management
- `/api/seances` - Session management
- `/api/presences` - Attendance tracking
- `/api/annonces` - Announcements
- `/api/documents` - Document management

## Authentication Flow

1. User navigates to `/login`
2. Enters email and password
3. Frontend calls `/api/users/login` endpoint
4. Backend returns authentication token
5. Token stored in localStorage
6. User redirected to appropriate dashboard based on role:
   - `admin` → `/admin/dashboard`
   - `enseignant` → `/teacher/dashboard`
   - `etudiant` → `/student/dashboard`

## API Service Layer

The application uses a centralized API service layer (`client/src/lib/api.ts`) for all backend communication:

```typescript
import { studentAPI, teacherAPI, moduleAPI } from '@/lib/api';

// Fetch all students
const students = await studentAPI.getAll();

// Create a new student
await studentAPI.create({ name, prenom, email, apogee, filiere_id });

// Update student
await studentAPI.update(studentId, { name, email });

// Delete student
await studentAPI.delete(studentId);
```

## Styling and Theming

### Global Theme Variables

All colors, spacing, and typography are defined as CSS variables in `client/src/index.css`:

```css
:root {
  --primary: #1a3a52;           /* Navy Blue */
  --accent: #d97706;            /* Terracotta */
  --background: #faf8f3;        /* Cream */
  --foreground: #2d3748;        /* Charcoal */
  /* ... more variables */
}
```

### Using Tailwind Classes

The application uses Tailwind CSS with custom semantic color names:

```jsx
<button className="bg-primary text-primary-foreground hover:opacity-90">
  Sign In
</button>
```

## Building for Production

```bash
pnpm build
```

This creates an optimized production build in the `dist/` directory.

## Testing

The application includes:
- TypeScript type checking
- ESLint for code quality
- Responsive design testing (mobile, tablet, desktop)

Run type checking:
```bash
pnpm check
```

## Accessibility

The application follows WCAG 2.1 AA compliance standards:
- High contrast color ratios
- Readable font sizes
- Keyboard navigation support
- Screen reader friendly
- Focus indicators on interactive elements

## Browser Support

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Optimizations

- Code splitting with Vite
- Lazy loading of route components
- Optimized images
- CSS minification
- Tree-shaking of unused code

## Known Limitations

1. **Mock Data Fallback**: If backend API is unavailable, the application falls back to mock data for demonstration purposes
2. **Authentication Token**: Currently stored in localStorage (consider using secure HTTP-only cookies for production)
3. **Real-Time Updates**: Currently uses polling; consider WebSockets for real-time features

## Future Enhancements

- [ ] Real-time notifications with WebSockets
- [ ] QR code scanning for attendance
- [ ] NFC badge reading
- [ ] Facial recognition (optional)
- [ ] Email/SMS notifications
- [ ] Advanced analytics and reporting
- [ ] Export to Excel/PDF
- [ ] Dark mode support
- [ ] Multi-language support (French, Arabic)
- [ ] Mobile app (React Native)

## Troubleshooting

### Dev Server Not Starting

```bash
# Kill any existing processes on port 3000
lsof -ti:3000 | xargs kill -9

# Restart dev server
pnpm dev
```

### API Connection Issues

1. Verify backend is running on `http://localhost:8000`
2. Check CORS configuration in backend
3. Verify API endpoints match the backend routes
4. Check browser console for error messages

### Build Errors

```bash
# Clear node_modules and reinstall
rm -rf node_modules pnpm-lock.yaml
pnpm install
pnpm build
```

## Contributing

When contributing to this project:

1. Follow the existing code style
2. Maintain the design philosophy
3. Update documentation for new features
4. Test across all roles (Admin, Teacher, Student)
5. Ensure responsive design works on all breakpoints

## License

© 2024 ENSA Safi. All rights reserved.

## Support

For issues or questions:
1. Check the troubleshooting section
2. Review the API documentation
3. Check browser console for error messages
4. Contact the development team

## Design Credits

**Design Philosophy**: Modern Institutional Minimalism with Moroccan Modern aesthetic
**Color Palette**: Inspired by ENSA Safi institutional branding
**Typography**: Professional hierarchy using Poppins and Inter fonts
**Icons**: Lucide React icon library

---

**Last Updated**: January 2025
**Version**: 1.0.0
**Status**: Production Ready
