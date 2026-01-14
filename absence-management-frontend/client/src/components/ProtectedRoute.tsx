import { useAuth, UserRole } from '@/contexts/AuthContext';
import { useLocation } from 'wouter';
import { useEffect } from 'react';
import { Loader2 } from 'lucide-react';

interface ProtectedRouteProps {
  children: React.ReactNode;
  allowedRoles?: UserRole[];
}

export function ProtectedRoute({ children, allowedRoles }: ProtectedRouteProps) {
  const { isAuthenticated, user, isLoading } = useAuth();
  const [, setLocation] = useLocation();

  useEffect(() => {
    if (!isLoading) {
      if (!isAuthenticated) {
        setLocation('/login');
      } else if (allowedRoles && user && !allowedRoles.includes(user.role)) {
        // Redirect to appropriate dashboard based on role
        switch (user.role) {
          case 'admin':
            setLocation('/admin/dashboard');
            break;
          case 'enseignant':
            setLocation('/teacher/dashboard');
            break;
          case 'etudiant':
            setLocation('/student/dashboard');
            break;
          default:
            setLocation('/login');
        }
      }
    }
  }, [isAuthenticated, isLoading, user, allowedRoles, setLocation]);

  if (isLoading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-background">
        <div className="flex flex-col items-center gap-3">
          <Loader2 className="w-8 h-8 animate-spin text-primary" />
          <p className="text-muted-foreground">Loading...</p>
        </div>
      </div>
    );
  }

  if (!isAuthenticated) {
    return null;
  }

  if (allowedRoles && user && !allowedRoles.includes(user.role)) {
    return null;
  }

  return <>{children}</>;
}
