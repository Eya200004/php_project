import { Sidebar } from './Sidebar';
import { useAuth } from '@/contexts/AuthContext';
import { Bell, Search } from 'lucide-react';
import { Input } from '@/components/ui/input';

interface DashboardLayoutProps {
  children: React.ReactNode;
  title?: string;
  description?: string;
}

export function DashboardLayout({ children, title, description }: DashboardLayoutProps) {
  const { user } = useAuth();

  return (
    <div className="flex h-screen bg-background">
      {/* Sidebar */}
      <Sidebar />

      {/* Main Content */}
      <div className="flex-1 flex flex-col lg:ml-64">
        {/* Top Header */}
        <header className="bg-white border-b border-border shadow-sm sticky top-0 z-30">
          <div className="px-6 py-4 flex items-center justify-between">
            <div className="flex-1">
              {title && <h1 className="text-2xl font-bold text-foreground">{title}</h1>}
              {description && <p className="text-sm text-muted-foreground mt-1">{description}</p>}
            </div>

            {/* Right Side Actions */}
            <div className="flex items-center gap-4">
              {/* Search Bar (hidden on mobile) */}
              <div className="hidden md:flex items-center relative">
                <Search className="absolute left-3 w-4 h-4 text-muted-foreground" />
                <Input
                  type="text"
                  placeholder="Search..."
                  className="pl-10 pr-4 py-2 w-64 text-sm"
                />
              </div>

              {/* Notifications */}
              <button className="relative p-2 hover:bg-secondary rounded-lg transition-colors duration-150">
                <Bell className="w-5 h-5 text-muted-foreground" />
                <span className="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
              </button>

              {/* User Avatar */}
              <div className="flex items-center gap-3 pl-4 border-l border-border">
                <div className="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-semibold">
                  {user?.name.charAt(0).toUpperCase()}{user?.prenom.charAt(0).toUpperCase()}
                </div>
                <div className="hidden sm:block">
                  <p className="text-sm font-medium text-foreground">{user?.name}</p>
                  <p className="text-xs text-muted-foreground capitalize">{user?.role}</p>
                </div>
              </div>
            </div>
          </div>
        </header>

        {/* Page Content */}
        <main className="flex-1 overflow-auto">
          <div className="p-6 lg:p-8">
            {children}
          </div>
        </main>
      </div>
    </div>
  );
}
