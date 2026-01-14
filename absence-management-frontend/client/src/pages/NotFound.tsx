import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { AlertCircle, Home } from 'lucide-react';
import { useLocation } from 'wouter';

export default function NotFound() {
  const [, setLocation] = useLocation();

  return (
    <div className="min-h-screen w-full flex items-center justify-center bg-gradient-to-br from-primary/5 via-background to-accent/5">
      <Card className="w-full max-w-lg mx-4 shadow-xl border-0 p-8">
        <div className="text-center">
          <div className="flex justify-center mb-6">
            <div className="relative">
              <div className="absolute inset-0 bg-red-100 rounded-full animate-pulse" />
              <AlertCircle className="relative h-16 w-16 text-red-600" />
            </div>
          </div>

          <h1 className="text-4xl font-bold text-foreground mb-2">404</h1>

          <h2 className="text-xl font-semibold text-foreground mb-4">
            Page Not Found
          </h2>

          <p className="text-muted-foreground mb-8 leading-relaxed">
            Sorry, the page you are looking for doesn't exist.
            <br />
            It may have been moved or deleted.
          </p>

          <div className="flex flex-col sm:flex-row gap-3 justify-center">
            <Button
              onClick={() => setLocation('/')}
              className="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2"
            >
              <Home className="w-4 h-4" />
              Go Home
            </Button>
          </div>
        </div>
      </Card>
    </div>
  );
}
