import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function TeacherAnnouncements() {
  return (
    <ProtectedRoute allowedRoles={['enseignant']}>
      <DashboardLayout
        title="Announcements"
        description="Post and manage announcements"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Announcement management features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
