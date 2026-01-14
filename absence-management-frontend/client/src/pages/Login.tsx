import { useState } from 'react';
import { useLocation } from 'wouter';
import { useAuth } from '@/contexts/AuthContext';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card } from '@/components/ui/card';
import { AlertCircle, Loader2 } from 'lucide-react';
import { toast } from 'sonner';
import { userAPI } from '@/lib/api';

/**
 * Login Page - Common entry point for all users (Admin, Teacher, Student)
 * Design: ENSA Safi Modern Institutional
 * - Clean, professional layout
 * - Email-based authentication
 * - Role-based redirection after login
 */
export default function Login() {
  const [, setLocation] = useLocation();
  const { login } = useAuth();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      // Call backend login API
      const data = await userAPI.login(email, password) as any;

      if (!data.token) {
        setError('Login failed. Please try again.');
        toast.error('Invalid credentials');
        return;
      }

      // Store token and user info
      localStorage.setItem('auth_token', data.token);
      localStorage.setItem('user_id', data.user.id);
      localStorage.setItem('user_name', data.user.name);
      localStorage.setItem('user_prenom', data.user.prenom);
      localStorage.setItem('user_email', data.user.email);
      localStorage.setItem('user_role', data.user.role);

      // Update auth context
      login(data.token, data.user);

      // Redirect based on role
      switch (data.user.role) {
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
          setLocation('/student/dashboard');
      }

      toast.success('Login successful!');
    } catch (err) {
      const errorMessage = err instanceof Error ? err.message : 'An error occurred';
      setError(errorMessage);
      toast.error(errorMessage);
      console.error('Login error:', err);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-primary/5 via-background to-accent/5 flex items-center justify-center px-4 py-12">
      {/* Background decorative elements */}
      <div className="absolute top-0 right-0 w-96 h-96 bg-accent/10 rounded-full blur-3xl -z-10"></div>
      <div className="absolute bottom-0 left-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl -z-10"></div>

      <div className="w-full max-w-md">
        {/* Header */}
        <div className="text-center mb-8">
          <div className="inline-flex items-center justify-center w-16 h-16 bg-primary rounded-2xl mb-4 shadow-lg">
            <span className="text-2xl font-bold text-primary-foreground">ES</span>
          </div>
          <h1 className="text-3xl font-bold text-primary mb-2">ENSA Safi</h1>
          <p className="text-muted-foreground">Absence Management System</p>
        </div>

        {/* Login Card */}
        <Card className="shadow-xl border-0">
          <div className="p-8">
            <h2 className="text-2xl font-bold text-foreground mb-6">Welcome Back</h2>

            {error && (
              <div className="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                <AlertCircle className="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" />
                <p className="text-sm text-red-700">{error}</p>
              </div>
            )}

            <form onSubmit={handleLogin} className="space-y-5">
              {/* Email Field */}
              <div>
                <label htmlFor="email" className="block text-sm font-medium text-foreground mb-2">
                  Email Address
                </label>
                <Input
                  id="email"
                  type="email"
                  placeholder="your.email@uca.ac.ma"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  required
                  disabled={loading}
                  className="w-full"
                />
                <p className="text-xs text-muted-foreground mt-1">
                  Use your institutional email (email@uca.ac.ma)
                </p>
              </div>

              {/* Password Field */}
              <div>
                <label htmlFor="password" className="block text-sm font-medium text-foreground mb-2">
                  Password
                </label>
                <Input
                  id="password"
                  type="password"
                  placeholder="Enter your password"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  required
                  disabled={loading}
                  className="w-full"
                />
              </div>

              {/* Submit Button */}
              <Button
                type="submit"
                disabled={loading}
                className="w-full bg-primary hover:opacity-90 text-primary-foreground font-semibold py-2.5 rounded-lg transition-all duration-200 flex items-center justify-center gap-2"
              >
                {loading ? (
                  <>
                    <Loader2 className="w-4 h-4 animate-spin" />
                    Signing in...
                  </>
                ) : (
                  'Sign In'
                )}
              </Button>

              {/* Info Text */}
              <p className="text-xs text-center text-muted-foreground pt-2">
                Your role (Admin, Teacher, or Student) determines your dashboard access
              </p>
            </form>
          </div>
        </Card>

        {/* Footer */}
        <p className="text-center text-xs text-muted-foreground mt-6">
          © 2025 ENSA Safi. All rights reserved.
        </p>
      </div>
    </div>
  );
}
