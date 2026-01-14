import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function StudentAnnouncements() {
  return (
    <ProtectedRoute allowedRoles={['etudiant']}>
      <DashboardLayout
        title="Announcements"
        description="View announcements from teachers"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Announcement view features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
