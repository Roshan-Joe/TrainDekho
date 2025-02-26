import React from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Users, Train, Ticket, TrendingUp } from 'lucide-react';

const AdminDashboard = () => {
  // Sample data - in a real app this would come from an API
  const stats = {
    totalUsers: 12584,
    activeTrains: 45,
    todayBookings: 238,
    revenue: 156430
  };

  const recentBookings = [
    { id: 1, from: "New York", to: "Boston", passengers: 2, date: "2025-02-12", status: "Confirmed" },
    { id: 2, from: "Chicago", to: "Detroit", passengers: 1, date: "2025-02-12", status: "Pending" },
    { id: 3, from: "Los Angeles", to: "San Francisco", passengers: 3, date: "2025-02-13", status: "Confirmed" },
  ];

  const activeTrains = [
    { id: "TR-101", name: "Express Line", route: "NYC - BOS", capacity: 280, occupied: 145 },
    { id: "TR-102", name: "Coastal Link", route: "LA - SF", capacity: 320, occupied: 290 },
    { id: "TR-103", name: "Metro Connect", route: "CHI - DET", capacity: 240, occupied: 98 },
  ];

  return (
    <div className="p-6 max-w-6xl mx-auto space-y-6">
      <h1 className="text-2xl font-bold mb-6">Train Booking Admin Dashboard</h1>
      
      {/* Stats Cards */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <Card>
          <CardContent className="pt-4">
            <div className="flex items-center space-x-4">
              <Users className="h-8 w-8 text-blue-500" />
              <div>
                <p className="text-sm font-medium text-gray-500">Total Users</p>
                <h3 className="text-2xl font-bold">{stats.totalUsers.toLocaleString()}</h3>
              </div>
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardContent className="pt-4">
            <div className="flex items-center space-x-4">
              <Train className="h-8 w-8 text-green-500" />
              <div>
                <p className="text-sm font-medium text-gray-500">Active Trains</p>
                <h3 className="text-2xl font-bold">{stats.activeTrains}</h3>
              </div>
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardContent className="pt-4">
            <div className="flex items-center space-x-4">
              <Ticket className="h-8 w-8 text-purple-500" />
              <div>
                <p className="text-sm font-medium text-gray-500">Today's Bookings</p>
                <h3 className="text-2xl font-bold">{stats.todayBookings}</h3>
              </div>
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardContent className="pt-4">
            <div className="flex items-center space-x-4">
              <TrendingUp className="h-8 w-8 text-yellow-500" />
              <div>
                <p className="text-sm font-medium text-gray-500">Revenue (USD)</p>
                <h3 className="text-2xl font-bold">${stats.revenue.toLocaleString()}</h3>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>

      {/* Active Trains Table */}
      <Card>
        <CardHeader>
          <CardTitle>Active Trains</CardTitle>
        </CardHeader>
        <CardContent>
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead>
                <tr className="border-b">
                  <th className="text-left p-2">Train ID</th>
                  <th className="text-left p-2">Name</th>
                  <th className="text-left p-2">Route</th>
                  <th className="text-left p-2">Capacity</th>
                  <th className="text-left p-2">Occupancy</th>
                </tr>
              </thead>
              <tbody>
                {activeTrains.map(train => (
                  <tr key={train.id} className="border-b">
                    <td className="p-2">{train.id}</td>
                    <td className="p-2">{train.name}</td>
                    <td className="p-2">{train.route}</td>
                    <td className="p-2">{train.capacity}</td>
                    <td className="p-2">
                      <div className="flex items-center">
                        <div className="w-24 bg-gray-200 rounded-full h-2.5 mr-2">
                          <div 
                            className="bg-blue-600 h-2.5 rounded-full"
                            style={{ width: `${(train.occupied/train.capacity * 100)}%` }}
                          ></div>
                        </div>
                        <span className="text-sm">{Math.round(train.occupied/train.capacity * 100)}%</span>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </CardContent>
      </Card>

      {/* Recent Bookings Table */}
      <Card>
        <CardHeader>
          <CardTitle>Recent Bookings</CardTitle>
        </CardHeader>
        <CardContent>
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead>
                <tr className="border-b">
                  <th className="text-left p-2">Booking ID</th>
                  <th className="text-left p-2">From</th>
                  <th className="text-left p-2">To</th>
                  <th className="text-left p-2">Passengers</th>
                  <th className="text-left p-2">Date</th>
                  <th className="text-left p-2">Status</th>
                </tr>
              </thead>
              <tbody>
                {recentBookings.map(booking => (
                  <tr key={booking.id} className="border-b">
                    <td className="p-2">#{booking.id}</td>
                    <td className="p-2">{booking.from}</td>
                    <td className="p-2">{booking.to}</td>
                    <td className="p-2">{booking.passengers}</td>
                    <td className="p-2">{booking.date}</td>
                    <td className="p-2">
                      <span className={`px-2 py-1 rounded-full text-xs ${
                        booking.status === 'Confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
                      }`}>
                        {booking.status}
                      </span>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </CardContent>
      </Card>
    </div>
  );
};

export default AdminDashboard;
